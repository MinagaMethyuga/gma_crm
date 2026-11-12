<?php

namespace App\Http\Controllers;

use App\Concerns\TogglesMessageReactions;
use App\Concerns\ValidatesJsonChat;
use App\Data\Countries;
use App\Data\Languages;
use App\Models\CommunityGroup;
use App\Models\CommunityGroupJoinRequest;
use App\Models\CommunityGroupMessage;
use App\Models\CommunityMessageReport;
use App\Models\CommunityPoll;
use App\Models\CommunityPollVote;
use App\Models\Friendship;
use App\Models\User;
use App\Notifications\CommunityGroupMessageNotification;
use App\Notifications\CommunityGroupReportNotification;
use App\Notifications\FriendRequestNotification;
use App\Services\Translation\MessageTranslator;
use Carbon\CarbonInterface;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MemberCommunityController extends Controller
{
    use TogglesMessageReactions;
    use ValidatesJsonChat;

    /**
     * How many messages in the last week count as "active" for discovery ranking.
     */
    private const ACTIVITY_WINDOW_DAYS = 7;

    /**
     * How much each recent message boosts a group's popularity score.
     */
    private const ACTIVITY_WEIGHT = 4;

    /**
     * How many groups a single member may create before they need an admin to help.
     */
    private const MEMBER_GROUP_LIMIT = 3;

    public function index()
    {
        $userId = auth()->id();

        $groups = CommunityGroup::with('creator')
            ->withCount('members')
            ->with(['members' => function ($q) use ($userId) {
                $q->where('users.id', $userId);
            }, 'joinRequests' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->where(function ($q) use ($userId) {
                $q->where(function ($visible) {
                    $visible->approved()
                        ->where('join_method', '!=', CommunityGroup::JOIN_PRIVATE);
                })->orWhereHas('members', function ($m) use ($userId) {
                    $m->where('users.id', $userId);
                })->orWhere('created_by', $userId);
            })
            ->latest()
            ->get();

        $friends = $this->friendsList(auth()->user());

        $groups->each(function ($group) use ($userId) {
            $group->is_member = $group->members->contains('id', $userId);
            $pendingRequest = $group->joinRequests->where('status', CommunityGroupJoinRequest::STATUS_PENDING)->first();
            $group->has_pending_request = $pendingRequest !== null;
            $group->pending_request_id = $pendingRequest?->id;
        });

        $weeklyActivity = $this->weeklyActivityCounts($groups->pluck('id'));
        $friendCounts = $this->friendMembershipCounts($friends->pluck('id'));

        $groups->each(function ($group) use ($weeklyActivity, $friendCounts) {
            $group->weekly_messages = $weeklyActivity[$group->id] ?? 0;
            $group->friend_members_count = $friendCounts[$group->id] ?? 0;
            $group->popularity_score = ($group->members_count ?? 0) + ($group->weekly_messages * self::ACTIVITY_WEIGHT);
        });

        $discoverable = $groups->where('is_member', false)
            ->where('status', CommunityGroup::STATUS_APPROVED)
            ->values();
        $public = $discoverable->filter(fn ($g) => $g->join_method !== CommunityGroup::JOIN_PRIVATE)->values();

        $popularGroups = $public->sortByDesc('popularity_score')->take(8)->values();
        $newGroups = $public->sortByDesc('created_at')->take(6)->values();
        $recommendedGroups = $public->where('friend_members_count', '>', 0)
            ->sortByDesc('friend_members_count')
            ->take(6)
            ->values();

        $pendingGroups = $groups->filter(fn ($g) => $g->status === CommunityGroup::STATUS_PENDING)->values();
        $categories = $this->discoverCategories($groups);
        $memberFaces = $this->memberFaces($popularGroups);

        $myGroupsCount = $groups->where('is_member', true)->count();
        $publicCount = $groups->filter(fn ($g) => $g->status === CommunityGroup::STATUS_APPROVED
            && $g->join_method !== CommunityGroup::JOIN_PRIVATE)->count();
        $joinedGroups = $groups->where('is_member', true)->values();
        $groupsCreatedCount = CommunityGroup::where('created_by', $userId)->count();
        $groupLimit = self::MEMBER_GROUP_LIMIT;
        $groupSlotsLeft = max(0, $groupLimit - $groupsCreatedCount);

        return view('member.community.index', compact(
            'groups',
            'myGroupsCount',
            'publicCount',
            'joinedGroups',
            'friends',
            'popularGroups',
            'newGroups',
            'recommendedGroups',
            'pendingGroups',
            'categories',
            'memberFaces',
            'groupsCreatedCount',
            'groupLimit',
            'groupSlotsLeft',
        ));
    }

    /**
     * Let a member start a new community. Submissions stay unpublished until an admin approves them.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => [
                'required', 'string', 'min:3', 'max:255',
                'not_regex:/[<>]/u',
                'not_regex:/[\x00-\x1F\x7F]/u',
            ],
            'category' => [
                'nullable', 'string',
                Rule::in(array_keys(CommunityGroup::CATEGORIES)),
            ],
            'description' => [
                'nullable', 'string', 'max:2000',
            ],
            'logo' => [
                'nullable', 'file', 'image',
                'mimes:jpg,jpeg,png,gif,webp',
                'extensions:jpg,jpeg,png,gif,webp',
                'max:2048',
                'dimensions:min_width=32,min_height=32,max_width=4096,max_height=4096',
            ],
        ]);

        $name = trim(preg_replace('/\s+/u', ' ', strip_tags($data['name'])));
        $slug = Str::slug($name);

        if ($slug === '') {
            return redirect()->route('member.community')
                ->withInput()
                ->with('error', 'Please choose a community name that contains letters or numbers.');
        }

        try {
            $result = DB::transaction(function () use ($user, $data, $name, $slug, $request) {
                if (CommunityGroup::where('created_by', $user->id)->count() >= self::MEMBER_GROUP_LIMIT) {
                    return 'limit';
                }

                if (CommunityGroup::withTrashed()->where('slug', $slug)->exists()) {
                    return 'duplicate';
                }

                $group = CommunityGroup::create([
                    'name' => $name,
                    'category' => $this->normaliseCategory($data['category'] ?? null),
                    'description' => $this->sanitiseText($data['description'] ?? null),
                    'join_method' => CommunityGroup::JOIN_OPEN,
                    'status' => CommunityGroup::STATUS_PENDING,
                    'created_by' => $user->id,
                ]);

                if ($request->hasFile('logo')) {
                    $group->logo = $request->file('logo')->store('community-logos', 'public');
                    $group->save();
                }

                $group->members()->attach($user->id, ['role' => 'admin', 'joined_at' => now()]);

                return $group;
            });
        } catch (UniqueConstraintViolationException) {
            // Two requests for the same name raced; the unique slug index caught it.
            $result = 'duplicate';
        }

        if ($result === 'limit') {
            return redirect()->route('member.community')->with('error',
                'You have reached the limit of '.self::MEMBER_GROUP_LIMIT.' communities. Contact the GMA team to create more.');
        }

        if ($result === 'duplicate') {
            return redirect()->route('member.community')
                ->withInput()
                ->with('error', 'A community with that name already exists. Please pick another name.');
        }

        return redirect()->route('member.community')
            ->with('success', 'Your community "'.$result->name.'" was submitted and is awaiting approval.');
    }

    /**
     * Store a known category key, or null when the member left it blank.
     */
    private function normaliseCategory(?string $category): ?string
    {
        $category = trim((string) $category);

        return $category === '' ? null : $category;
    }

    /**
     * Strip markup and control characters before persisting free text.
     */
    private function sanitiseText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim(strip_tags($value));
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);

        return $value === '' ? null : $value;
    }

    /**
     * Message totals per group over the activity window, used to rank "popular" groups.
     */
    private function weeklyActivityCounts($groupIds)
    {
        return CommunityGroupMessage::whereIn('community_group_id', $groupIds)
            ->where('created_at', '>=', now()->subDays(self::ACTIVITY_WINDOW_DAYS))
            ->selectRaw('community_group_id, COUNT(*) as message_total')
            ->groupBy('community_group_id')
            ->pluck('message_total', 'community_group_id')
            ->map(fn ($total) => (int) $total)
            ->all();
    }

    /**
     * How many of the member's friends belong to each group.
     */
    private function friendMembershipCounts($friendIds)
    {
        if ($friendIds->isEmpty()) {
            return [];
        }

        return DB::table('community_group_members')
            ->whereIn('user_id', $friendIds)
            ->selectRaw('community_group_id, COUNT(*) as friend_total')
            ->groupBy('community_group_id')
            ->pluck('friend_total', 'community_group_id')
            ->map(fn ($total) => (int) $total)
            ->all();
    }

    /**
     * Discover topics with the number of visible groups in each, busiest first.
     */
    private function discoverCategories($groups)
    {
        return $groups
            ->filter(fn ($group) => $group->status === CommunityGroup::STATUS_APPROVED)
            ->groupBy(fn ($group) => $group->categorySlug())
            ->map(fn ($items, $slug) => [
                'slug' => $slug,
                'label' => $items->first()->categoryLabel(),
                'count' => $items->count(),
            ])
            ->sortByDesc('count')
            ->values()
            ->all();
    }

    /**
     * A small stack of member avatars per group for social proof on the cards.
     */
    private function memberFaces($groups)
    {
        $groupIds = $groups->pluck('id');

        if ($groupIds->isEmpty()) {
            return [];
        }

        $storage = Storage::disk('public');

        return DB::table('community_group_members')
            ->join('users', 'users.id', '=', 'community_group_members.user_id')
            ->whereIn('community_group_members.community_group_id', $groupIds)
            ->orderBy('community_group_members.user_id')
            ->get(['community_group_members.community_group_id', 'users.id', 'users.name', 'users.avatar'])
            ->groupBy('community_group_id')
            ->map(fn ($rows) => $rows->take(4)->map(function ($row) use ($storage) {
                $hasAvatar = $row->avatar && $storage->exists($row->avatar);

                return [
                    'name' => $row->name,
                    'initials' => Str::initials((string) $row->name, true) ?: '?',
                    'avatar_url' => $hasAvatar ? asset('storage/'.$row->avatar) : null,
                ];
            })->values())
            ->all();
    }

    public function join(CommunityGroup $communityGroup)
    {
        if ($communityGroup->status !== CommunityGroup::STATUS_APPROVED) {
            return redirect()->route('member.community')->with('error', 'This group is not published yet.');
        }

        if ($communityGroup->join_method === CommunityGroup::JOIN_PRIVATE) {
            return redirect()->route('member.community')->with('error', 'This group is private.');
        }

        if ($communityGroup->join_method === CommunityGroup::JOIN_REQUEST) {
            return redirect()->route('member.community')->with('error', 'This group requires approval. Use Request to Join.');
        }

        $communityGroup->members()->syncWithoutDetaching([
            auth()->id() => ['role' => 'member', 'joined_at' => now()],
        ]);

        return redirect()->route('member.community')->with('success', 'You joined '.$communityGroup->name.'.');
    }

    public function request(CommunityGroup $communityGroup)
    {
        if ($communityGroup->status !== CommunityGroup::STATUS_APPROVED) {
            return redirect()->route('member.community')->with('error', 'This group is not published yet.');
        }

        if ($communityGroup->join_method !== CommunityGroup::JOIN_REQUEST) {
            return redirect()->route('member.community')->with('error', 'This group does not require a join request.');
        }

        if ($communityGroup->members()->where('users.id', auth()->id())->exists()) {
            return redirect()->route('member.community')->with('error', 'You are already a member of this group.');
        }

        CommunityGroupJoinRequest::updateOrCreate(
            ['community_group_id' => $communityGroup->id, 'user_id' => auth()->id()],
            ['status' => CommunityGroupJoinRequest::STATUS_PENDING],
        );

        return redirect()->route('member.community')->with('success', 'Join request sent to '.$communityGroup->name.'.');
    }

    public function cancelRequest(CommunityGroupJoinRequest $joinRequest)
    {
        abort_unless($joinRequest->user_id === auth()->id(), 403);

        $joinRequest->update(['status' => CommunityGroupJoinRequest::STATUS_DECLINED]);

        return redirect()->route('member.community')->with('success', 'Join request cancelled.');
    }

    public function leave(CommunityGroup $communityGroup)
    {
        if ($communityGroup->created_by === auth()->id()) {
            return redirect()->route('member.community')->with('error', 'Group creators cannot leave their own group.');
        }

        $communityGroup->members()->detach(auth()->id());

        return redirect()->route('member.community')->with('success', 'You left '.$communityGroup->name.'.');
    }

    public function messages(CommunityGroup $communityGroup)
    {
        $this->ensureMember($communityGroup);

        $messages = $communityGroup->messages()
            ->with($this->messageRelations())
            ->latest('id')
            ->take(200)
            ->get()
            ->sortBy('id')
            ->values()
            ->map(fn ($message) => $this->messagePayload($message));

        $pinned = $communityGroup->messages()
            ->with($this->messageRelations())
            ->whereNotNull('pinned_at')
            ->orderByDesc('pinned_at')
            ->get()
            ->map(fn ($message) => $this->messagePayload($message));

        return response()->json([
            'messages' => $messages,
            'pinned' => $pinned,
            'can_pin' => $this->isGroupAdmin($communityGroup, auth()->id()),
            'can_report' => true,
        ]);
    }

    public function sendMessage(CommunityGroup $communityGroup, Request $request)
    {
        $this->ensureMember($communityGroup);

        if ($communityGroup->admin_only_messages && ! $this->isGroupAdmin($communityGroup, auth()->id())) {
            abort(403, 'Only admins can send messages in this group.');
        }

        if ($communityGroup->message_cooldown_count && $communityGroup->message_cooldown_minutes) {
            $minutes = (int) $communityGroup->message_cooldown_minutes;
            $threshold = (int) $communityGroup->message_cooldown_count;
            $baseQuery = $communityGroup->messages()
                ->where('user_id', auth()->id())
                ->where('created_at', '>=', now()->subMinutes($minutes))
                ->orderBy('created_at');

            $recentCount = (clone $baseQuery)->count();

            if ($recentCount >= $threshold) {
                $earliest = $baseQuery->value('created_at');
                $waitUntil = $earliest ? $earliest->copy()->addMinutes($minutes) : now()->addMinutes($minutes);
                $retryAfter = max(1, (int) now()->diffInSeconds($waitUntil, false));

                return response()->json([
                    'message' => 'You are sending messages too fast. Please wait before sending again.',
                    'retry_after' => $retryAfter,
                ], 429);
            }
        }

        [$data, $validationError] = $this->validateChat($request, [
            'message' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:5120'],
            'reply_to_id' => [
                'nullable',
                'integer',
                Rule::exists('community_group_messages', 'id')->where(
                    fn ($query) => $query->where('community_group_id', $communityGroup->id)
                ),
            ],
        ]);

        if ($validationError) {
            return $validationError;
        }

        $messageText = $this->sanitiseText($data['message'] ?? '') ?? '';
        $image = $request->file('image');
        $replyToId = $data['reply_to_id'] ?? null;

        if ($messageText === '' && ! $image) {
            return response()->json(['message' => 'The message must have text or an image.'], 422);
        }

        // Chat attachments live on the private disk and are served only through
        // the access-checked stream route, never the public webroot.
        $imagePath = $image ? $image->store('community-messages', 'local') : null;

        $message = $communityGroup->messages()->create([
            'user_id' => auth()->id(),
            'message' => $messageText,
            'image' => $imagePath,
            'reply_to_id' => $replyToId,
            'type' => CommunityGroupMessage::TYPE_TEXT,
        ]);

        $communityGroup->members()
            ->where('users.id', '!=', auth()->id())
            ->get()
            ->each(function ($member) use ($message, $communityGroup) {
                $member->notify(new CommunityGroupMessageNotification(
                    auth()->user(),
                    $message,
                    $communityGroup->name,
                ));
            });

        return response()->json(['message' => $this->messagePayload($message->load($this->messageRelations()))], 201);
    }

    public function deleteMessages(CommunityGroup $communityGroup, Request $request)
    {
        $this->ensureMember($communityGroup);

        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1', 'max:50'],
            'ids.*' => ['integer', 'distinct'],
        ]);

        $query = $communityGroup->messages()->whereIntegerInRaw('id', $data['ids']);

        if (! $this->isGroupAdmin($communityGroup, auth()->id())) {
            $query->where('user_id', auth()->id());
        }

        $ids = $query->pluck('id');
        $this->purgeReactionsFor(CommunityGroupMessage::class, $ids);

        $deleted = $query->delete();

        return response()->json(['deleted' => $deleted]);
    }

    public function members(CommunityGroup $communityGroup)
    {
        $this->ensureMember($communityGroup);

        $members = $communityGroup->members()
            ->orderByPivot('joined_at')
            ->get()
            ->sortBy(fn ($user) => $user->id === $communityGroup->created_by ? 0 : 1)
            ->values()
            ->map(function ($user) use ($communityGroup) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar_url' => $user->avatarUrl(),
                    'role' => $user->pivot->role ?? 'member',
                    'joined_at' => $this->formatChatDate($user->pivot->joined_at ? Carbon::parse($user->pivot->joined_at) : null, 'MMM D, Y'),
                    'is_creator' => $user->id === $communityGroup->created_by,
                    'is_admin' => $this->isGroupAdmin($communityGroup, $user->id),
                    'is_own' => $user->id === auth()->id(),
                ];
            });

        return response()->json([
            'members' => $members,
            'can_manage' => $this->isGroupAdmin($communityGroup, auth()->id()),
            'pending_reports' => $communityGroup->messageReports()
                ->where('status', CommunityMessageReport::STATUS_PENDING)
                ->count(),
            'settings' => $this->groupSettings($communityGroup),
        ]);
    }

    public function updateSettings(CommunityGroup $communityGroup, Request $request)
    {
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can change community settings.');

        $data = $request->validate([
            'admin_only_messages' => ['required', 'boolean'],
            'message_cooldown_count' => ['required', 'integer', 'min:0', 'max:1000'],
            'message_cooldown_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
        ]);

        $communityGroup->update([
            'admin_only_messages' => (bool) $data['admin_only_messages'],
            'message_cooldown_count' => (int) $data['message_cooldown_count'] > 0 ? (int) $data['message_cooldown_count'] : null,
            'message_cooldown_minutes' => (int) $data['message_cooldown_minutes'] > 0 ? (int) $data['message_cooldown_minutes'] : null,
        ]);

        return response()->json([
            'settings' => $this->groupSettings($communityGroup),
        ]);
    }

    public function memberProfile(CommunityGroup $communityGroup, User $user)
    {
        $this->ensureMember($communityGroup);

        $membership = $communityGroup->members()
            ->whereKey($user->id)
            ->first();

        abort_unless($membership, 403, 'User is not a member of this group.');

        return response()->json([
            'profile' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatarUrl(),
                'role' => $membership->pivot->role ?? 'member',
                'job_title' => $user->job_title,
                'company_name' => $user->company_name,
                'industry' => $user->industry,
                'country' => Countries::name($user->country),
                'joined_at' => $this->formatChatDate($membership->pivot->joined_at ? Carbon::parse($membership->pivot->joined_at) : null, 'MMM D, Y'),
                'is_creator' => $user->id === $communityGroup->created_by,
                'is_admin' => $this->isGroupAdmin($communityGroup, $user->id),
                'is_own' => $user->id === auth()->id(),
                'friend_status' => $this->friendStatus($user),
            ],
        ]);
    }

    public function friendRequests()
    {
        $user = auth()->user();

        $incoming = Friendship::where('receiver_id', $user->id)
            ->where('status', Friendship::STATUS_PENDING)
            ->with('sender')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Friendship $f) => $this->friendRequestPayload($f, $f->sender, 'incoming'))
            ->values();

        $outgoing = Friendship::where('sender_id', $user->id)
            ->where('status', Friendship::STATUS_PENDING)
            ->with('receiver')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Friendship $f) => $this->friendRequestPayload($f, $f->receiver, 'outgoing'))
            ->values();

        return response()->json([
            'incoming' => $incoming,
            'outgoing' => $outgoing,
            'incoming_count' => $incoming->count(),
        ]);
    }

    public function searchFriends(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if (strlen($term) < 2) {
            return response()->json([
                'message' => 'Please enter at least 2 characters to search.',
                'errors' => ['q' => ['Please enter at least 2 characters to search.']],
            ], 422);
        }

        $like = '%'.str_replace(['%', '_'], ['\%', '\_'], $term).'%';

        $users = User::query()
            ->whereKeyNot(auth()->id())
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('company_name', 'like', $like);
            })
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json([
            'results' => $users->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar_url' => $user->avatarUrl(),
                    'company_name' => $user->company_name,
                    'job_title' => $user->job_title,
                    'initials' => $user->initials(),
                    'friend_status' => $this->friendStatus($user),
                ];
            })->values(),
        ]);
    }

    public function sendFriendRequest(User $user)
    {
        abort_if($user->id === auth()->id(), 422, 'You cannot add yourself as a friend.');

        $status = $this->friendStatus($user);

        if ($status === 'friends') {
            return response()->json(['friend_status' => 'friends']);
        }
        if ($status === 'pending_sent') {
            return response()->json(['friend_status' => 'pending_sent']);
        }
        if ($status === 'pending_received') {
            Friendship::where('sender_id', $user->id)
                ->where('receiver_id', auth()->id())
                ->update(['status' => Friendship::STATUS_ACCEPTED]);

            return response()->json(['friend_status' => 'friends']);
        }

        Friendship::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'status' => Friendship::STATUS_PENDING,
        ]);

        $user->notify(new FriendRequestNotification(auth()->user()));

        return response()->json(['friend_status' => 'pending_sent']);
    }

    public function cancelFriendRequest(User $user)
    {
        Friendship::where('sender_id', auth()->id())
            ->where('receiver_id', $user->id)
            ->where('status', Friendship::STATUS_PENDING)
            ->delete();

        return response()->json(['friend_status' => 'none']);
    }

    public function acceptFriendRequest(User $user)
    {
        Friendship::where('sender_id', $user->id)
            ->where('receiver_id', auth()->id())
            ->where('status', Friendship::STATUS_PENDING)
            ->firstOrFail()
            ->update(['status' => Friendship::STATUS_ACCEPTED]);

        return response()->json(['friend_status' => 'friends']);
    }

    public function declineFriendRequest(User $user)
    {
        Friendship::where('sender_id', $user->id)
            ->where('receiver_id', auth()->id())
            ->where('status', Friendship::STATUS_PENDING)
            ->delete();

        return response()->json(['friend_status' => 'none']);
    }

    public function removeMember(CommunityGroup $communityGroup, User $user)
    {
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can remove members.');

        if ($user->id === $communityGroup->created_by) {
            abort(422, 'The group creator cannot be removed.');
        }
        if ($user->id === auth()->id()) {
            abort(422, 'You cannot remove yourself.');
        }

        $communityGroup->members()->detach($user->id);

        return response()->json(['ok' => true]);
    }

    public function makeAdmin(CommunityGroup $communityGroup, User $user)
    {
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can assign admins.');

        if ($user->id === $communityGroup->created_by) {
            abort(422, 'The group creator is already an admin.');
        }
        abort_unless($communityGroup->members()->whereKey($user->id)->exists(), 422, 'User is not a member.');

        $communityGroup->members()->updateExistingPivot($user->id, ['role' => 'admin']);

        return response()->json(['ok' => true]);
    }

    public function revokeAdmin(CommunityGroup $communityGroup, User $user)
    {
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can revoke admins.');

        if ($user->id === $communityGroup->created_by) {
            abort(422, 'The group creator cannot be demoted.');
        }
        abort_unless($communityGroup->members()->whereKey($user->id)->exists(), 422, 'User is not a member.');

        $communityGroup->members()->updateExistingPivot($user->id, ['role' => 'member']);

        return response()->json(['ok' => true]);
    }

    private function ensureMember(CommunityGroup $communityGroup): void
    {
        abort_unless($communityGroup->members()->whereKey(auth()->id())->exists(), 403);
    }

    private function friendRequestPayload(Friendship $friendship, ?User $other, string $direction): array
    {
        return [
            'id' => $friendship->id,
            'direction' => $direction,
            'user' => $other ? [
                'id' => $other->id,
                'name' => $other->name,
                'email' => $other->email,
                'avatar_url' => $other->avatarUrl(),
                'initials' => $other->initials(),
                'company_name' => $other->company_name,
                'job_title' => $other->job_title,
                'country' => Countries::name($other->country),
            ] : null,
            'sent_at' => $friendship->created_at?->toIso8601String(),
        ];
    }

    private function friendsList(User $user)
    {
        return Friendship::where('status', Friendship::STATUS_ACCEPTED)
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->orderByDesc('updated_at')
            ->get()
            ->map(function (Friendship $f) use ($user) {
                return $f->sender_id === $user->id ? $f->receiver : $f->sender;
            })
            ->values();
    }

    private function groupSettings(CommunityGroup $communityGroup): array
    {
        return [
            'admin_only_messages' => (bool) $communityGroup->admin_only_messages,
            'message_cooldown_count' => $communityGroup->message_cooldown_count,
            'message_cooldown_minutes' => $communityGroup->message_cooldown_minutes,
        ];
    }

    private function isGroupAdmin(CommunityGroup $communityGroup, int $userId): bool
    {
        if ($communityGroup->created_by === $userId) {
            return true;
        }

        return $communityGroup->members()
            ->whereKey($userId)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    private function friendStatus(User $user): string
    {
        if ($user->id === auth()->id()) {
            return 'none';
        }

        $friendship = Friendship::where(function ($q) use ($user) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
        })->first();

        if (! $friendship) {
            return 'none';
        }
        if ($friendship->status === Friendship::STATUS_ACCEPTED) {
            return 'friends';
        }

        return $friendship->sender_id === auth()->id() ? 'pending_sent' : 'pending_received';
    }

    /**
     * Get the locale used to render community chat dates and times.
     *
     * Members pick this in settings, so one response can mix locales depending
     * on who is asking. This is deliberately not memoised on the controller,
     * because Laravel reuses the resolved controller across requests.
     */
    private function chatLocale(): string
    {
        return auth()->user()?->preferredLocale() ?? Languages::default();
    }

    /**
     * Copy a date into the member's chosen language.
     *
     * Carbon's locale() both mutates the instance and returns it, and its
     * declared return type is a union, so it is called for its side effect to
     * keep the instance typed. The copy stops the locale leaking back into the
     * model's own date attributes.
     *
     * The type is CarbonInterface rather than Carbon because Carbon::parse()
     * hands back an immutable instance.
     */
    private function chatDate(?CarbonInterface $date): ?CarbonInterface
    {
        if ($date === null) {
            return null;
        }

        $localized = $date->copy();
        $localized->locale($this->chatLocale());

        return $localized;
    }

    /**
     * Format a community chat date in the member's chosen language.
     */
    private function formatChatDate(?CarbonInterface $date, string $format): ?string
    {
        return $this->chatDate($date)?->isoFormat($format);
    }

    /**
     * Describe how long ago a community chat date was, in the member's language.
     */
    private function chatDateForHumans(?CarbonInterface $date): ?string
    {
        return $this->chatDate($date)?->diffForHumans();
    }

    private function messagePayload(CommunityGroupMessage $message): array
    {
        $translator = app(MessageTranslator::class);
        $viewerLang = auth()->user()?->preferred_language;

        $reply = null;
        if ($message->reply_to_id && $message->relationLoaded('replyTo')) {
            $replyTo = $message->getRelation('replyTo');
            if ($replyTo) {
                $reply = [
                    'id' => $replyTo->id,
                    'message' => $translator->translateMessage($replyTo->message ?? '', null, $viewerLang),
                    'image_url' => $replyTo->imageUrl(),
                    'user_name' => $replyTo->user?->name ?? 'Member',
                ];
            }
        }

        $poll = null;
        if ($message->poll_id && $message->relationLoaded('poll')) {
            $pollModel = $message->getRelation('poll');
            if ($pollModel) {
                $poll = $this->pollPayload($pollModel, auth()->id());
            }
        } elseif ($message->poll_id) {
            $poll = $this->pollPayload($message->poll()->with('votes')->first(), auth()->id());
        }

        return [
            'id' => $message->id,
            'message' => $translator->translateMessage($message->message ?? '', null, $viewerLang),
            'image_url' => $message->imageUrl(),
            'user_name' => $message->user?->name ?? 'Member',
            'avatar_url' => $message->user?->avatarUrl() ?: null,
            'is_own' => $message->user_id === auth()->id(),
            'time' => $this->formatChatDate($message->created_at, 'h:mm A'),
            'type' => $message->type ?? CommunityGroupMessage::TYPE_TEXT,
            'reply_to_id' => $message->reply_to_id,
            'reply' => $reply,
            'poll_id' => $message->poll_id,
            'poll' => $poll,
            'pinned_at' => $message->pinned_at?->toIso8601String(),
            'pinned_by' => $message->pinned_by,
            'is_pinned' => $message->isPinned(),
            'reactions' => $this->reactionPayload($message),
        ];
    }

    private function pollPayload(?CommunityPoll $poll, ?int $userId): ?array
    {
        if (! $poll) {
            return null;
        }

        $poll->loadMissing('votes');

        $votes = $poll->votes ?? collect();
        $total = $votes->count();
        $options = collect($poll->options ?? [])->map(function ($opt, $i) use ($votes, $total) {
            $count = $votes->where('option_index', $i)->count();
            $percent = $total > 0 ? round(($count / $total) * 100, 1) : 0;

            return [
                'index' => $i,
                'text' => $opt['text'] ?? $opt,
                'count' => $count,
                'percent' => $percent,
            ];
        })->values();

        $userVote = $userId ? $votes->firstWhere('user_id', $userId) : null;

        return [
            'id' => $poll->id,
            'question' => $poll->question,
            'options' => $options,
            'allow_multiple' => (bool) $poll->allow_multiple,
            'total_votes' => $total,
            'user_vote_index' => $userVote?->option_index,
            'user_voted' => $userVote !== null,
            'is_closed' => $poll->isClosed(),
            'closes_at' => $poll->closes_at?->toIso8601String(),
            'created_by' => $poll->created_by,
        ];
    }

    private function messageRelations(): array
    {
        return ['user', 'replyTo.user', 'poll.votes', 'reactions.user:id,name'];
    }

    public function pinMessage(CommunityGroup $communityGroup, CommunityGroupMessage $message)
    {
        $this->ensureMember($communityGroup);
        $this->assertMessageInGroup($communityGroup, $message);
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can pin messages.');

        $message->update(['pinned_at' => now(), 'pinned_by' => auth()->id()]);

        return response()->json([
            'message' => $this->messagePayload($message->fresh($this->messageRelations())),
            'can_pin' => true,
        ]);
    }

    public function unpinMessage(CommunityGroup $communityGroup, CommunityGroupMessage $message)
    {
        $this->ensureMember($communityGroup);
        $this->assertMessageInGroup($communityGroup, $message);
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can unpin messages.');

        $message->update(['pinned_at' => null, 'pinned_by' => null]);

        return response()->json([
            'message' => $this->messagePayload($message->fresh($this->messageRelations())),
        ]);
    }

    public function toggleReaction(CommunityGroup $communityGroup, CommunityGroupMessage $message, Request $request)
    {
        $this->ensureMember($communityGroup);
        $this->assertMessageInGroup($communityGroup, $message);

        $result = $this->toggleReactionOn($message, $request->input('emoji'));

        return response()->json([
            'active' => $result['active'],
            'reactions' => $result['reactions'],
            'message' => $this->messagePayload($message),
        ]);
    }

    public function reportMessage(CommunityGroup $communityGroup, CommunityGroupMessage $message, Request $request)
    {
        $this->ensureMember($communityGroup);
        $this->assertMessageInGroup($communityGroup, $message);
        if ($message->user_id === auth()->id()) {
            return response()->json(['message' => 'You cannot report your own message.'], 422);
        }

        [$data, $validationError] = $this->validateChat($request, [
            'reason' => ['required', 'string', Rule::in(array_keys(CommunityMessageReport::REASONS))],
            'details' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($validationError) {
            return $validationError;
        }

        $alreadyPending = CommunityMessageReport::where('community_group_message_id', $message->id)
            ->where('reporter_id', auth()->id())
            ->where('status', CommunityMessageReport::STATUS_PENDING)
            ->exists();

        if ($alreadyPending) {
            return response()->json(['message' => 'You have already reported this message.'], 422);
        }

        $report = CommunityMessageReport::create([
            'community_group_id' => $communityGroup->id,
            'community_group_message_id' => $message->id,
            'reported_user_id' => $message->user_id,
            'reporter_id' => auth()->id(),
            'reason' => $data['reason'],
            'details' => $this->sanitiseText($data['details'] ?? null),
            'message_snapshot' => Str::limit(strip_tags((string) $message->message), 500),
            'status' => CommunityMessageReport::STATUS_PENDING,
        ]);

        foreach ($communityGroup->members()->wherePivot('role', 'admin')->get() as $admin) {
            if ($admin->id !== auth()->id() && $admin->id !== $message->user_id) {
                $admin->notify(new CommunityGroupReportNotification(
                    auth()->user(),
                    $message,
                    $communityGroup->name,
                    $report->reasonLabel(),
                ));
            }
        }

        return response()->json(['reported' => true], 201);
    }

    public function reports(CommunityGroup $communityGroup)
    {
        $this->ensureMember($communityGroup);
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can review reports.');

        $status = request()->query('status', 'pending');

        $reports = $communityGroup->messageReports()
            ->with(['reporter', 'reportedUser'])
            ->when(in_array($status, ['pending', 'resolved'], true), fn ($q) => $q->whereIn('status', $status === 'pending'
                ? [CommunityMessageReport::STATUS_PENDING]
                : [CommunityMessageReport::STATUS_REMOVED, CommunityMessageReport::STATUS_DISMISSED]))
            ->latest()
            ->get()
            ->map(fn (CommunityMessageReport $report) => [
                'id' => $report->id,
                'reason' => $report->reason,
                'reason_label' => $report->reasonLabel(),
                'details' => $report->details,
                'status' => $report->status,
                'message_snapshot' => $report->message_snapshot,
                'message_id' => $report->community_group_message_id,
                'message_exists' => $report->community_group_message_id !== null,
                'reporter_name' => $report->reporter?->name ?? 'Member',
                'reported_name' => $report->reportedUser?->name ?? 'Former member',
                'created_at' => $this->chatDateForHumans($report->created_at),
                'reviewed_at' => $this->chatDateForHumans($report->reviewed_at),
            ]);

        return response()->json([
            'reports' => $reports,
            'pending_count' => $communityGroup->messageReports()->where('status', CommunityMessageReport::STATUS_PENDING)->count(),
        ]);
    }

    public function removeReportedMessage(CommunityGroup $communityGroup, CommunityMessageReport $report)
    {
        $this->ensureMember($communityGroup);
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can remove messages.');
        abort_unless($report->community_group_id === $communityGroup->id, 404);

        $message = $report->community_group_message_id
            ? $communityGroup->messages()->find($report->community_group_message_id)
            : null;

        DB::transaction(function () use ($report, $message) {
            if ($message) {
                $message->delete();
            }

            $report->update([
                'status' => CommunityMessageReport::STATUS_REMOVED,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            if ($report->community_group_message_id) {
                CommunityMessageReport::where('community_group_message_id', $report->community_group_message_id)
                    ->where('status', CommunityMessageReport::STATUS_PENDING)
                    ->update(['status' => CommunityMessageReport::STATUS_REMOVED, 'reviewed_by' => auth()->id(), 'reviewed_at' => now()]);
            }
        });

        return response()->json(['removed' => (bool) $message]);
    }

    public function dismissReport(CommunityGroup $communityGroup, CommunityMessageReport $report)
    {
        $this->ensureMember($communityGroup);
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can review reports.');
        abort_unless($report->community_group_id === $communityGroup->id, 404);

        $report->update([
            'status' => CommunityMessageReport::STATUS_DISMISSED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return response()->json(['dismissed' => true]);
    }

    public function createPoll(CommunityGroup $communityGroup, Request $request)
    {
        $this->ensureMember($communityGroup);
        abort_unless($this->isGroupAdmin($communityGroup, auth()->id()), 403, 'Only group admins can create polls.');

        [$data, $validationError] = $this->validateChat($request, [
            'question' => ['required', 'string', 'min:3', 'max:500'],
            'options' => ['required', 'array', 'min:2', 'max:8'],
            'options.*' => ['required', 'string', 'max:200'],
            'allow_multiple' => ['prohibited'],
            'closes_at' => ['nullable', 'date'],
        ]);

        if ($validationError) {
            return $validationError;
        }

        $options = collect($data['options'])
            ->map(fn ($opt) => trim((string) $opt))
            ->filter()
            ->unique()
            ->values()
            ->map(fn ($opt) => ['text' => $this->sanitiseText($opt)])
            ->values();

        if ($options->count() < 2) {
            return response()->json(['message' => 'A poll needs at least two unique options.'], 422);
        }

        $question = $this->sanitiseText($data['question']);

        $poll = $communityGroup->polls()->create([
            'created_by' => auth()->id(),
            'question' => $question,
            'options' => $options->all(),
            'allow_multiple' => false,
            'closes_at' => $data['closes_at'] ?? null,
        ]);

        $message = $communityGroup->messages()->create([
            'user_id' => auth()->id(),
            'message' => $question,
            'poll_id' => $poll->id,
            'type' => CommunityGroupMessage::TYPE_POLL,
        ]);

        $communityGroup->members()
            ->where('users.id', '!=', auth()->id())
            ->get()
            ->each(function ($member) use ($message, $communityGroup) {
                $member->notify(new CommunityGroupMessageNotification(
                    auth()->user(),
                    $message,
                    $communityGroup->name,
                ));
            });

        return response()->json([
            'message' => $this->messagePayload($message->fresh($this->messageRelations())),
        ], 201);
    }

    public function votePoll(CommunityGroup $communityGroup, CommunityPoll $poll, Request $request)
    {
        $this->ensureMember($communityGroup);
        abort_unless($poll->community_group_id === $communityGroup->id, 404);

        if ($poll->isClosed()) {
            return response()->json(['message' => 'This poll has closed.'], 422);
        }

        [$data, $validationError] = $this->validateChat($request, [
            'option_index' => ['required', 'integer', 'min:0'],
        ]);

        if ($validationError) {
            return $validationError;
        }

        $index = (int) $data['option_index'];
        $optionCount = count($poll->options ?? []);

        if ($index >= $optionCount) {
            return response()->json(['message' => 'That option is not part of this poll.'], 422);
        }

        $userId = auth()->id();

        CommunityPollVote::updateOrCreate(
            [
                'community_poll_id' => $poll->id,
                'user_id' => $userId,
            ],
            ['option_index' => $index]
        );

        $poll->load('votes');

        return response()->json(['poll' => $this->pollPayload($poll, $userId)]);
    }

    private function assertMessageInGroup(CommunityGroup $communityGroup, CommunityGroupMessage $message): void
    {
        abort_unless($message->community_group_id === $communityGroup->id, 404);
    }
}
