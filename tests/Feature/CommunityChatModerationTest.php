<?php

use App\Enums\UserRole;
use App\Models\CommunityGroup;
use App\Models\CommunityGroupMessage;
use App\Models\CommunityMessageReport;
use App\Models\CommunityPollVote;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\CommunityGroupMessageNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

function chatPlan(): Plan
{
    return Plan::firstOrCreate(
        ['slug' => 'professional'],
        [
            'name' => 'Professional',
            'stripe_product_id' => 'prod_chat_test',
            'stripe_price_id' => 'price_chat_test',
            'price' => 99,
            'billing_period' => 'yearly',
        ]
    );
}

function chatUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'plan_id' => chatPlan()->id,
        'plan_subscribed_at' => now()->subMonth(),
        'role' => UserRole::Member,
    ], $overrides));
}

function chatGroup(User $creator, array $overrides = []): CommunityGroup
{
    $group = CommunityGroup::create(array_merge([
        'name' => 'Chat Group '.uniqid(),
        'category' => 'networking',
        'description' => 'A group for chatting.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $creator->id,
    ], $overrides));

    $group->members()->attach($creator->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

function joinGroup(CommunityGroup $group, User $user, string $role = 'member'): void
{
    $group->members()->attach($user->id, ['role' => $role, 'joined_at' => now()]);
}

function postMessage(CommunityGroup $group, User $author, string $body = 'Hello there'): CommunityGroupMessage
{
    return $group->messages()->create([
        'user_id' => $author->id,
        'message' => $body,
        'type' => CommunityGroupMessage::TYPE_TEXT,
    ]);
}

/** Posts through the real endpoint, which is what fans the notification out. */
function sendMessageViaRoute(CommunityGroup $group, User $author, string $body = 'Hello there'): CommunityGroupMessage
{
    $response = test()->actingAs($author)
        ->postJson(route('member.community.messages.send', [$group]), ['message' => $body])
        ->assertCreated();

    return $group->messages()->findOrFail($response->json('message.id'));
}

test('group admins can pin and unpin messages', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $message = postMessage($group, $member, 'Read this first');

    $this->actingAs($admin)
        ->postJson(route('member.community.messages.pin', [$group, $message]))
        ->assertOk()
        ->assertJsonPath('message.is_pinned', true);

    $this->assertNotNull($message->fresh()->pinned_at);

    $this->actingAs($admin)
        ->postJson(route('member.community.messages.unpin', [$group, $message]))
        ->assertOk()
        ->assertJsonPath('message.is_pinned', false);

    $this->assertNull($message->fresh()->pinned_at);
});

test('non admins cannot pin messages', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);
    $message = postMessage($group, $member);

    $this->actingAs($member)
        ->postJson(route('member.community.messages.pin', [$group, $message]))
        ->assertForbidden();

    $this->assertNull($message->fresh()->pinned_at);
});

test('members cannot pin messages from another group', function () {
    $admin = chatUser();
    $groupA = chatGroup($admin);
    $groupB = chatGroup($admin);

    $message = postMessage($groupA, $admin, 'Wrong group');

    $this->actingAs($admin)
        ->postJson(route('member.community.messages.pin', [$groupB, $message]))
        ->assertNotFound();
});

test('pinned messages are listed separately from the chat feed', function () {
    $admin = chatUser();
    $group = chatGroup($admin);
    $message = postMessage($group, $admin, 'Pinned note');

    $this->actingAs($admin)
        ->postJson(route('member.community.messages.pin', [$group, $message]));

    $response = $this->actingAs($admin)
        ->getJson(route('member.community.messages', $group))
        ->assertOk()
        ->assertJsonPath('can_pin', true);

    $this->assertCount(1, $response->json('pinned'));
    $this->assertSame($message->id, $response->json('pinned.0.id'));
});

test('members can reply to a message', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $original = postMessage($group, $admin, 'Who is joining the trip?');

    $this->actingAs($member)
        ->postJson(route('member.community.messages.send', $group), [
            'message' => 'I am in.',
            'reply_to_id' => $original->id,
        ])
        ->assertCreated()
        ->assertJsonPath('message.reply.id', $original->id)
        ->assertJsonPath('message.reply.message', 'Who is joining the trip?');

    $this->assertSame($original->id, $group->messages()->latest('id')->first()->reply_to_id);
});

test('non members cannot reply', function () {
    $admin = chatUser();
    $outsider = chatUser();
    $group = chatGroup($admin);

    $this->actingAs($outsider)
        ->postJson(route('member.community.messages.send', $group), ['message' => 'Hello'])
        ->assertForbidden();
});

test('a reply cannot point at a message from another group', function () {
    $admin = chatUser();
    $groupA = chatGroup($admin);
    $groupB = chatGroup($admin);

    $otherGroupMessage = postMessage($groupA, $admin, 'Private to group A');

    $response = $this->actingAs($admin)
        ->postJson(route('member.community.messages.send', $groupB), [
            'message' => 'Leaking reply',
            'reply_to_id' => $otherGroupMessage->id,
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['reply_to_id']]);

    expect(strtolower((string) $response->json('message')))->toContain('reply');

    $this->assertNull($groupB->messages()->first());
});

test('members can report another members message', function () {
    Notification::fake();

    $admin = chatUser();
    $member = chatUser();
    $reporter = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);
    joinGroup($group, $reporter);

    $message = postMessage($group, $member, 'Check out my site, cheap stuff');

    $this->actingAs($reporter)
        ->postJson(route('member.community.messages.report', [$group, $message]), [
            'reason' => CommunityMessageReport::REASON_SPAM,
            'details' => 'Unsolicited advertising.',
        ])
        ->assertCreated()
        ->assertJsonPath('reported', true);

    $this->assertDatabaseHas('community_message_reports', [
        'community_group_message_id' => $message->id,
        'reporter_id' => $reporter->id,
        'reported_user_id' => $member->id,
        'status' => CommunityMessageReport::STATUS_PENDING,
    ]);
});

test('unknown report reasons are rejected', function () {
    $admin = chatUser();
    $member = chatUser();
    $reporter = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);
    joinGroup($group, $reporter);

    $message = postMessage($group, $member);

    $this->actingAs($reporter)
        ->postJson(route('member.community.messages.report', [$group, $message]), ['reason' => 'because-i-said-so'])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['reason']]);

    $this->assertDatabaseCount('community_message_reports', 0);
});

test('members cannot report their own message', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $message = postMessage($group, $member, 'My own words');

    $this->actingAs($member)
        ->postJson(route('member.community.messages.report', [$group, $message]), [
            'reason' => CommunityMessageReport::REASON_SPAM,
        ])
        ->assertStatus(422);

    $this->assertDatabaseCount('community_message_reports', 0);
});

test('the same member cannot report a message twice', function () {
    $admin = chatUser();
    $member = chatUser();
    $reporter = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);
    joinGroup($group, $reporter);

    $message = postMessage($group, $member);

    $this->actingAs($reporter)
        ->postJson(route('member.community.messages.report', [$group, $message]), ['reason' => CommunityMessageReport::REASON_SPAM])
        ->assertCreated();

    $this->actingAs($reporter)
        ->postJson(route('member.community.messages.report', [$group, $message]), ['reason' => CommunityMessageReport::REASON_SPAM])
        ->assertStatus(422);

    $this->assertDatabaseCount('community_message_reports', 1);
});

test('group admins can list pending reports but members cannot', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $message = postMessage($group, $member, 'Spammy message');

    CommunityMessageReport::create([
        'community_group_id' => $group->id,
        'community_group_message_id' => $message->id,
        'reported_user_id' => $member->id,
        'reporter_id' => $admin->id,
        'reason' => CommunityMessageReport::REASON_SPAM,
        'message_snapshot' => 'Spammy message',
        'status' => CommunityMessageReport::STATUS_PENDING,
    ]);

    $this->actingAs($admin)
        ->getJson(route('member.community.reports', $group))
        ->assertOk()
        ->assertJsonPath('pending_count', 1)
        ->assertJsonPath('reports.0.reported_name', $member->name);

    $this->actingAs($member)
        ->getJson(route('member.community.reports', $group))
        ->assertForbidden();
});

test('group admins can remove a reported message and clear the queue', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $message = postMessage($group, $member, 'Remove me');

    $report = CommunityMessageReport::create([
        'community_group_id' => $group->id,
        'community_group_message_id' => $message->id,
        'reported_user_id' => $member->id,
        'reporter_id' => $admin->id,
        'reason' => CommunityMessageReport::REASON_HARASSMENT,
        'message_snapshot' => 'Remove me',
        'status' => CommunityMessageReport::STATUS_PENDING,
    ]);

    $this->actingAs($admin)
        ->postJson(route('member.community.reports.remove', [$group, $report]))
        ->assertOk()
        ->assertJsonPath('removed', true);

    $this->assertDatabaseMissing('community_group_messages', ['id' => $message->id]);
    $this->assertSame(CommunityMessageReport::STATUS_REMOVED, $report->fresh()->status);
});

test('dismissing a report keeps the message', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $message = postMessage($group, $member, 'Keep me');

    $report = CommunityMessageReport::create([
        'community_group_id' => $group->id,
        'community_group_message_id' => $message->id,
        'reported_user_id' => $member->id,
        'reporter_id' => $admin->id,
        'reason' => CommunityMessageReport::REASON_OTHER,
        'status' => CommunityMessageReport::STATUS_PENDING,
    ]);

    $this->actingAs($admin)
        ->postJson(route('member.community.reports.dismiss', [$group, $report]))
        ->assertOk();

    $this->assertDatabaseHas('community_group_messages', ['id' => $message->id]);
    $this->assertSame(CommunityMessageReport::STATUS_DISMISSED, $report->fresh()->status);
});

test('members cannot resolve reports', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $report = CommunityMessageReport::create([
        'community_group_id' => $group->id,
        'reporter_id' => $member->id,
        'reason' => CommunityMessageReport::REASON_SPAM,
        'status' => CommunityMessageReport::STATUS_PENDING,
    ]);

    $this->actingAs($member)
        ->postJson(route('member.community.reports.dismiss', [$group, $report]))
        ->assertForbidden();
});

test('group admins can create polls and members cannot', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $this->actingAs($admin)
        ->postJson(route('member.community.polls.store', $group), [
            'question' => 'What should we cover next?',
            'options' => ['Fundraising', 'Hiring'],
        ])
        ->assertCreated()
        ->assertJsonPath('message.type', 'poll')
        ->assertJsonPath('message.poll.total_votes', 0);

    $this->assertSame(1, $group->polls()->count());
    $this->assertNotNull($group->messages()->first()->poll_id);

    $this->actingAs($member)
        ->postJson(route('member.community.polls.store', $group), [
            'question' => 'Should I be allowed?',
            'options' => ['Yes', 'No'],
        ])
        ->assertForbidden();
});

test('polls need at least two unique options', function () {
    $admin = chatUser();
    $group = chatGroup($admin);

    $this->actingAs($admin)
        ->postJson(route('member.community.polls.store', $group), [
            'question' => 'Duplicate options only',
            'options' => ['Same', 'Same'],
        ])
        ->assertStatus(422);

    $this->assertSame(0, $group->polls()->count());
});

test('polls are single choice so multi select requests are rejected', function () {
    $admin = chatUser();
    $group = chatGroup($admin);

    $this->actingAs($admin)
        ->postJson(route('member.community.polls.store', $group), [
            'question' => 'Should multi select work?',
            'options' => ['A', 'B'],
            'allow_multiple' => true,
        ])
        ->assertStatus(422);

    $this->assertSame(0, $group->polls()->count());
});

test('members can vote once and change their vote', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $poll = $group->polls()->create([
        'created_by' => $admin->id,
        'question' => 'Pick one',
        'options' => [['text' => 'A'], ['text' => 'B']],
    ]);

    $this->actingAs($member)
        ->postJson(route('member.community.polls.vote', [$group, $poll]), ['option_index' => 0])
        ->assertOk()
        ->assertJsonPath('poll.total_votes', 1)
        ->assertJsonPath('poll.user_vote_index', 0)
        ->assertJsonPath('poll.options.0.percent', 100);

    $this->actingAs($member)
        ->postJson(route('member.community.polls.vote', [$group, $poll]), ['option_index' => 1])
        ->assertOk()
        ->assertJsonPath('poll.total_votes', 1)
        ->assertJsonPath('poll.user_vote_index', 1);

    $this->assertSame(1, CommunityPollVote::where('community_poll_id', $poll->id)->count());
});

test('votes outside the option range are rejected', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $poll = $group->polls()->create([
        'created_by' => $admin->id,
        'question' => 'Pick one',
        'options' => [['text' => 'A'], ['text' => 'B']],
    ]);

    $this->actingAs($member)
        ->postJson(route('member.community.polls.vote', [$group, $poll]), ['option_index' => 7])
        ->assertStatus(422);

    $this->assertSame(0, CommunityPollVote::count());
});

test('members cannot vote in polls from another group', function () {
    $admin = chatUser();
    $outsider = chatUser();
    $groupA = chatGroup($admin);
    $groupB = chatGroup($admin);

    $poll = $groupA->polls()->create([
        'created_by' => $admin->id,
        'question' => 'Pick one',
        'options' => [['text' => 'A'], ['text' => 'B']],
    ]);

    $this->actingAs($outsider)
        ->postJson(route('member.community.polls.vote', [$groupB, $poll]), ['option_index' => 0])
        ->assertForbidden();
});

test('closed polls reject new votes', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    $poll = $group->polls()->create([
        'created_by' => $admin->id,
        'question' => 'Already over',
        'options' => [['text' => 'A'], ['text' => 'B']],
        'closes_at' => now()->subMinute(),
    ]);

    $this->actingAs($member)
        ->postJson(route('member.community.polls.vote', [$group, $poll]), ['option_index' => 0])
        ->assertStatus(422);

    $this->assertSame(0, CommunityPollVote::count());
});

test('the member list exposes a pending report count for admins', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    CommunityMessageReport::create([
        'community_group_id' => $group->id,
        'reporter_id' => $member->id,
        'reason' => CommunityMessageReport::REASON_SPAM,
        'status' => CommunityMessageReport::STATUS_PENDING,
    ]);

    $this->actingAs($admin)
        ->getJson(route('member.community.members', $group))
        ->assertOk()
        ->assertJsonPath('pending_reports', 1)
        ->assertJsonPath('can_manage', true);
});

test('a group message notification carries the group id so it can deep link', function () {
    Notification::fake();

    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin, ['name' => 'Startup Foundation']);
    joinGroup($group, $member);

    sendMessageViaRoute($group, $admin, 'hello');

    Notification::assertSentTo(
        $member,
        CommunityGroupMessageNotification::class,
        function (CommunityGroupMessageNotification $notification, array $channels, User $recipient) use ($group, $admin) {
            $payload = $notification->toArray($recipient);

            return $payload['group_id'] === $group->id
                && $payload['group_name'] === 'Startup Foundation'
                && $payload['preview'] === 'hello'
                && $payload['sender_id'] === $admin->id;
        }
    );
});

test('the notification list exposes the group id needed to open the chat', function () {
    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin, ['name' => 'Startup Foundation']);
    joinGroup($group, $member);

    $message = sendMessageViaRoute($group, $admin, 'hello');

    $this->actingAs($member)
        ->getJson(route('member.notifications'))
        ->assertOk()
        ->assertJsonPath('notifications.0.type', 'group_message')
        ->assertJsonPath('notifications.0.data.group_id', $group->id)
        ->assertJsonPath('notifications.0.data.group_name', 'Startup Foundation')
        ->assertJsonPath('notifications.0.data.preview', 'hello');

    expect($message->exists)->toBeTrue();
});

test('a group message notification deep link is only sent to other members', function () {
    Notification::fake();

    $admin = chatUser();
    $member = chatUser();
    $group = chatGroup($admin);
    joinGroup($group, $member);

    sendMessageViaRoute($group, $admin, 'hello');

    Notification::assertNotSentTo([$admin], CommunityGroupMessageNotification::class);
    Notification::assertSentToTimes($member, CommunityGroupMessageNotification::class, 1);
});

/* ── Arrival cursor ──────────────────────────────────────────────────────
   The bell polls with ?since= so a delivery can raise a toast without
   re-sending the whole history. created_at is the cursor rather than id
   because `id` is a UUID, and `where id > ?` on random strings would drop
   notifications. */

function insertNotification(User $user, array $overrides = []): string
{
    $id = (string) Str::uuid();

    DB::table('notifications')->insert([
        'id' => $id,
        'type' => CommunityGroupMessageNotification::class,
        'notifiable_type' => User::class,
        'notifiable_id' => $user->id,
        'data' => Crypt::encryptString(json_encode(array_merge([
            'type' => 'group_message',
            'sender_id' => 1,
            'sender_name' => 'Dana Dorcas',
            'message' => 'sent a message',
            'preview' => 'hi',
        ], $overrides['data'] ?? []))),
        'read_at' => $overrides['read_at'] ?? null,
        'created_at' => $overrides['created_at'] ?? now(),
        'updated_at' => now(),
    ]);

    return $id;
}

test('the notification cursor returns only what arrived from that moment, oldest first', function () {
    Carbon::setTestNow(Carbon::parse('2026-01-01 10:00:00'));

    $member = chatUser();

    // Distinct seconds on purpose: created_at has no sub-second precision, so
    // same-second rows would fall back to the UUID tiebreaker and sort randomly.
    insertNotification($member, ['data' => ['preview' => 'oldest'], 'created_at' => now()->subSeconds(30)]);
    insertNotification($member, ['data' => ['preview' => 'middle'], 'created_at' => now()->subSeconds(20)]);
    insertNotification($member, ['data' => ['preview' => 'newest'], 'created_at' => now()->subSeconds(10)]);

    $since = now()->subSeconds(20);

    $this->actingAs($member)
        ->getJson(route('member.notifications').'?since='.urlencode($since->toIso8601String()))
        ->assertOk()
        ->assertJsonCount(2, 'notifications')
        // Oldest first so the bell can surface them in arrival order.
        ->assertJsonPath('notifications.0.data.preview', 'middle')
        ->assertJsonPath('notifications.1.data.preview', 'newest');
});

test('the notification cursor is inclusive so messages sharing a timestamp are not lost', function () {
    $member = chatUser();
    $at = now()->subMinute();

    // The column has no sub-second precision, so a message sent in the same
    // second as the cursor is a real case. The client overlaps by a second and
    // dedupes by id; it needs the boundary row back to do that.
    insertNotification($member, ['data' => ['preview' => 'first'], 'created_at' => $at]);
    insertNotification($member, ['data' => ['preview' => 'second'], 'created_at' => $at]);

    $this->actingAs($member)
        ->getJson(route('member.notifications').'?since='.urlencode($at->toIso8601String()))
        ->assertOk()
        ->assertJsonCount(2, 'notifications');
});

test('the notification list reports the unread count and the newest timestamp', function () {
    Carbon::setTestNow(Carbon::parse('2026-01-01 10:00:00'));

    $member = chatUser();

    insertNotification($member, ['created_at' => now()->subSeconds(30)]);
    insertNotification($member, ['created_at' => now()->subSeconds(20)]);
    insertNotification($member, ['read_at' => now(), 'created_at' => now()->subSeconds(10)]);

    $this->actingAs($member)
        ->getJson(route('member.notifications'))
        ->assertOk()
        ->assertJsonCount(3, 'notifications')
        ->assertJsonPath('unread_count', 2)
        // Newest first by default, so the read row leads.
        ->assertJsonPath('notifications.0.created_at', now()->subSeconds(10)->toIso8601String())
        ->assertJsonPath('notifications.0.read', true)
        ->assertJsonPath('notifications.2.read', false)
        ->assertJsonPath('latest_created_at', now()->subSeconds(10)->toIso8601String());

    // An empty inbox still has to hand back the key, otherwise the client
    // cursor can never start.
    $empty = chatUser();
    $this->actingAs($empty)
        ->getJson(route('member.notifications'))
        ->assertOk()
        ->assertJsonCount(0, 'notifications')
        ->assertJsonPath('unread_count', 0)
        ->assertJsonPath('latest_created_at', null);
});

test('the notification cursor only ever returns the caller own notifications', function () {
    $member = chatUser();
    $other = chatUser();

    insertNotification($other, ['data' => ['preview' => 'not yours'], 'created_at' => now()->subMinute()]);
    $mine = insertNotification($member, ['data' => ['preview' => 'mine'], 'created_at' => now()->subMinute()]);

    $this->actingAs($member)
        ->getJson(route('member.notifications').'?since='.urlencode(now()->subHours(1)->toIso8601String()))
        ->assertOk()
        ->assertJsonCount(1, 'notifications')
        ->assertJsonPath('notifications.0.id', $mine);
});

test('an unreadable notification cursor falls back to the recent list', function () {
    $member = chatUser();
    insertNotification($member, ['created_at' => now()->subMinute()]);

    $this->actingAs($member)
        ->getJson(route('member.notifications').'?since=not-a-date')
        ->assertOk()
        ->assertJsonCount(1, 'notifications');
});
