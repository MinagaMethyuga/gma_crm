<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityGroup;
use App\Models\CommunityGroupJoinRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = CommunityGroup::with('creator')
            ->withCount(['members', 'pendingJoinRequests'])
            ->latest()
            ->get();

        $pendingGroups = CommunityGroup::with('creator')
            ->withCount('members')
            ->pending()
            ->latest()
            ->get();

        $pendingRequests = CommunityGroupJoinRequest::with(['user', 'communityGroup'])
            ->where('status', CommunityGroupJoinRequest::STATUS_PENDING)
            ->latest()
            ->get();

        $joinedGroups = auth()->user()->communityGroups()->withCount('members')->latest()->get();

        $friends = Friendship::where('status', Friendship::STATUS_ACCEPTED)
            ->where(function ($q) {
                $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id());
            })
            ->with(['sender', 'receiver'])
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($f) {
                return $f->sender_id === auth()->id() ? $f->receiver : $f->sender;
            })
            ->values();

        return view('admin.community', compact('groups', 'pendingGroups', 'pendingRequests', 'joinedGroups', 'friends'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:60',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'join_method' => 'required|in:'.implode(',', array_keys(CommunityGroup::JOIN_METHODS)),
        ]);

        $group = CommunityGroup::create([
            'name' => $validated['name'],
            'category' => $this->normaliseCategory($validated['category'] ?? null),
            'description' => $validated['description'] ?? null,
            'join_method' => $validated['join_method'],
            'created_by' => auth()->id(),
        ]);

        if ($request->hasFile('logo')) {
            $group->logo = $request->file('logo')->store('community-logos', 'public');
            $group->save();
        }

        $group->members()->attach(auth()->id(), ['role' => 'admin']);

        return redirect()->route('admin.community')->with('success', 'Community group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityGroup $communityGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:60',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'join_method' => 'required|in:'.implode(',', array_keys(CommunityGroup::JOIN_METHODS)),
        ]);

        $data = [
            'name' => $validated['name'],
            'category' => $this->normaliseCategory($validated['category'] ?? null),
            'description' => $validated['description'] ?? null,
            'join_method' => $validated['join_method'],
        ];

        if ($request->hasFile('logo')) {
            if ($communityGroup->logo && Storage::disk('public')->exists($communityGroup->logo)) {
                Storage::disk('public')->delete($communityGroup->logo);
            }
            $data['logo'] = $request->file('logo')->store('community-logos', 'public');
        }

        $communityGroup->update($data);

        return redirect()->route('admin.community')->with('success', 'Community group updated successfully.');
    }

    /**
     * Approve a pending join request.
     */
    public function approve(CommunityGroupJoinRequest $joinRequest)
    {
        if ($joinRequest->community_group_id && $joinRequest->user_id) {
            $joinRequest->communityGroup->members()->syncWithoutDetaching([
                $joinRequest->user_id => ['role' => 'member', 'joined_at' => now()],
            ]);
        }

        $joinRequest->update(['status' => CommunityGroupJoinRequest::STATUS_APPROVED]);

        return redirect()->route('admin.community')->with('success', 'Join request approved.');
    }

    /**
     * Decline a pending join request.
     */
    public function decline(CommunityGroupJoinRequest $joinRequest)
    {
        $joinRequest->update(['status' => CommunityGroupJoinRequest::STATUS_DECLINED]);

        return redirect()->route('admin.community')->with('success', 'Join request declined.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityGroup $communityGroup)
    {
        $communityGroup->delete();

        return redirect()->route('admin.community')->with('success', 'Community group deleted successfully.');
    }

    /**
     * Publish a member-created community so it shows up in member discovery.
     */
    public function approveGroup(CommunityGroup $communityGroup)
    {
        $communityGroup->update(['status' => CommunityGroup::STATUS_APPROVED]);

        return redirect()->route('admin.community')->with('success', 'Community "'.$communityGroup->name.'" is now published.');
    }

    /**
     * Decline a member-created community submission.
     */
    public function declineGroup(CommunityGroup $communityGroup)
    {
        $communityGroup->update(['status' => CommunityGroup::STATUS_REJECTED]);

        return redirect()->route('admin.community')->with('success', 'Community "'.$communityGroup->name.'" was declined.');
    }

    /**
     * Store a known category key, or null when the admin left it blank.
     */
    private function normaliseCategory(?string $category): ?string
    {
        $category = trim((string) $category);

        return $category === '' ? null : $category;
    }
}
