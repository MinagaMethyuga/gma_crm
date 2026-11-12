<?php

use App\Enums\UserRole;
use App\Models\CommunityGroup;
use App\Models\CommunityGroupMessage;
use App\Models\DirectMessage;
use App\Models\Friendship;
use App\Models\MessageReaction;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\QueryException;

// Self-contained on purpose: these run in the same process as the other chat
// suites, so the names must not clash with theirs.
function reactionPlan(): Plan
{
    return Plan::firstOrCreate(
        ['slug' => 'professional'],
        [
            'name' => 'Professional',
            'stripe_product_id' => 'prod_reaction_test',
            'stripe_price_id' => 'price_reaction_test',
            'price' => 99,
            'billing_period' => 'yearly',
        ]
    );
}

function reactionUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'plan_id' => reactionPlan()->id,
        'plan_subscribed_at' => now()->subMonth(),
        'role' => UserRole::Member,
    ], $overrides));
}

function reactionGroup(User $creator, array $overrides = []): CommunityGroup
{
    $group = CommunityGroup::create(array_merge([
        'name' => 'Reaction Group '.uniqid(),
        'category' => 'networking',
        'description' => 'A group for chatting.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $creator->id,
    ], $overrides));

    $group->members()->attach($creator->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

function joinReactionGroup(CommunityGroup $group, User $user, string $role = 'member'): void
{
    $group->members()->attach($user->id, ['role' => $role, 'joined_at' => now()]);
}

function reactionMessage(CommunityGroup $group, User $author, string $body = 'Hello there'): CommunityGroupMessage
{
    return $group->messages()->create([
        'user_id' => $author->id,
        'message' => $body,
        'type' => CommunityGroupMessage::TYPE_TEXT,
    ]);
}

function befriend(User $a, User $b): void
{
    Friendship::create([
        'sender_id' => $a->id,
        'receiver_id' => $b->id,
        'status' => Friendship::STATUS_ACCEPTED,
    ]);
}

function reactionDirectMessage(User $from, User $to, string $body = 'Hi'): DirectMessage
{
    return DirectMessage::create([
        'sender_id' => $from->id,
        'receiver_id' => $to->id,
        'message' => $body,
    ]);
}

/** Emoji are written as escapes so the file's encoding cannot change them. */
test('a group member can react to a message and take it back', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);

    $message = reactionMessage($group, $alice, 'Ship it?');
    $thumbsUp = "\u{1F44D}";

    $response = test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $thumbsUp])
        ->assertOk()
        ->assertJsonPath('active', true)
        ->assertJsonPath('reactions.0.emoji', $thumbsUp)
        ->assertJsonPath('reactions.0.count', 1)
        ->assertJsonPath('reactions.0.mine', true);

    expect($message->reactions()->count())->toBe(1);
    expect($response->json('reactions.0.names'))->toContain($bob->name);

    // Same emoji again means "I take it back".
    test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $thumbsUp])
        ->assertOk()
        ->assertJsonPath('active', false)
        ->assertJsonPath('reactions', []);

    expect($message->reactions()->count())->toBe(0);
});

test('a member cannot store the same reaction twice', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);

    $message = reactionMessage($group, $alice);
    $message->reactions()->create(['user_id' => $bob->id, 'emoji' => "\u{1F525}"]);

    // The unique index is what actually protects the count.
    expect(fn () => $message->reactions()->create(['user_id' => $bob->id, 'emoji' => "\u{1F525}"]))
        ->toThrow(QueryException::class);

    expect($message->reactions()->count())->toBe(1);
});

test('two members reacting at once do not duplicate the count', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);

    $message = reactionMessage($group, $alice);
    $thumbsUp = "\u{1F44D}";

    // Another tab inserts the same reaction between our check and our insert.
    $raced = false;
    MessageReaction::creating(function ($reaction) use (&$raced) {
        if ($raced) {
            return;
        }
        $raced = true;
        MessageReaction::withoutEvents(fn () => MessageReaction::create([
            'message_type' => $reaction->message_type,
            'message_id' => $reaction->message_id,
            'user_id' => $reaction->user_id,
            'emoji' => $reaction->emoji,
        ]));
    });

    $reactions = test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $thumbsUp])
        ->assertOk()
        ->assertJsonPath('active', true)
        ->json('reactions');

    // The race collapses to one row instead of erroring or doubling the count.
    expect($message->reactions()->count())->toBe(1);
    expect($reactions[0]['count'])->toBe(1);
    expect($reactions[0]['mine'])->toBeTrue();
});

test('reaction counts aggregate across members and keep whitelist order', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $carol = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);
    joinReactionGroup($group, $carol);

    $message = reactionMessage($group, $alice);
    $laugh = "\u{1F602}";
    $thumbsUp = "\u{1F44D}";

    test()->actingAs($bob)->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $laugh])->assertOk();
    test()->actingAs($carol)->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $thumbsUp])->assertOk();
    test()->actingAs($carol)->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $laugh])->assertOk();

    $payload = test()->actingAs($alice)
        ->getJson(route('member.community.messages', [$group]))
        ->assertOk()
        ->json('messages.0.reactions');

    // The whitelist order wins, regardless of who reacted first.
    expect(array_column($payload, 'emoji'))->toBe([$thumbsUp, $laugh]);
    expect(collect($payload)->pluck('count')->all())->toBe([1, 2]);

    // The member reacting sees their own marks, the sender does not.
    expect($payload[1]['mine'])->toBeFalse();
    expect(collect(test()->actingAs($bob)->getJson(route('member.community.messages', [$group]))->json('messages.0.reactions'))->pluck('mine')->all())
        ->toBe([false, true]);
});

test('messages listing includes reactions', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);

    $message = reactionMessage($group, $alice, 'Reactions?');
    $heart = MessageReaction::EMOJI[1];

    test()->actingAs($bob)->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $heart])->assertOk();

    $row = collect(test()->actingAs($bob)->getJson(route('member.community.messages', [$group]))->json('messages'))
        ->firstWhere('id', $message->id);

    expect($row['reactions'])->toHaveCount(1);
    expect($row['reactions'][0]['emoji'])->toBe($heart);
    expect($row['reactions'][0]['mine'])->toBeTrue();
});

test('a message without reactions reports an empty list', function () {
    $alice = reactionUser();
    $group = reactionGroup($alice);
    reactionMessage($group, $alice, 'No reactions here');

    $row = test()->actingAs($alice)->getJson(route('member.community.messages', [$group]))->json('messages.0');

    expect($row['reactions'])->toBe([]);
});

test('only the whitelisted reactions are accepted', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);
    $message = reactionMessage($group, $alice);

    foreach (MessageReaction::EMOJI as $emoji) {
        test()->actingAs($bob)
            ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $emoji])
            ->assertOk();
    }

    expect($message->reactions()->count())->toBe(count(MessageReaction::EMOJI));

    test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => "\u{1F575}\u{FE0F}"])
        ->assertStatus(422);

    test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => '<script>alert(1)</script>'])
        ->assertStatus(422);

    expect($message->reactions()->count())->toBe(count(MessageReaction::EMOJI));
});

test('a missing emoji is rejected', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);
    $message = reactionMessage($group, $alice);

    test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]))
        ->assertStatus(422);
});

test('a bare emoji does not become a second heart', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);
    $message = reactionMessage($group, $alice);

    // "❤" without the variation selector is the same reaction as "❤️".
    test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => "\u{2764}"])
        ->assertOk()
        ->assertJsonPath('reactions.0.emoji', MessageReaction::EMOJI[1]);

    expect($message->reactions()->count())->toBe(1);

    test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => MessageReaction::EMOJI[1]])
        ->assertOk()
        ->assertJsonPath('reactions', []);
});

test('non members cannot react to group messages', function () {
    $alice = reactionUser();
    $outsider = reactionUser();
    $group = reactionGroup($alice);
    $message = reactionMessage($group, $alice);

    test()->actingAs($outsider)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => "\u{1F44D}"])
        ->assertForbidden();

    expect($message->reactions()->count())->toBe(0);
});

test('a message from another group cannot be reacted to through this group', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    $other = reactionGroup($alice, ['name' => 'Other '.uniqid()]);
    joinReactionGroup($group, $bob);
    $message = reactionMessage($other, $alice);

    test()->actingAs($bob)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => "\u{1F44D}"])
        ->assertNotFound();
});

test('a friend can react to a direct message and take it back', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    befriend($alice, $bob);
    $message = reactionDirectMessage($bob, $alice, 'Ping');
    $clap = "\u{1F44F}";

    test()->actingAs($alice)
        ->postJson(route('member.friends.messages.reaction', [$bob, $message]), ['emoji' => $clap])
        ->assertOk()
        ->assertJsonPath('active', true)
        ->assertJsonPath('reactions.0.count', 1)
        ->assertJsonPath('reactions.0.mine', true);

    expect($message->reactions()->count())->toBe(1);

    test()->actingAs($alice)
        ->postJson(route('member.friends.messages.reaction', [$bob, $message]), ['emoji' => $clap])
        ->assertOk()
        ->assertJsonPath('active', false)
        ->assertJsonPath('reactions', []);

    expect($message->reactions()->count())->toBe(0);
});

test('direct message listing includes reactions', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    befriend($alice, $bob);
    $message = reactionDirectMessage($bob, $alice, 'Nice work');
    $party = "\u{1F389}";

    test()->actingAs($alice)->postJson(route('member.friends.messages.reaction', [$bob, $message]), ['emoji' => $party])->assertOk();

    $row = collect(test()->actingAs($alice)->getJson(route('member.friends.messages', [$bob]))->json('messages'))
        ->firstWhere('id', $message->id);

    expect($row['reactions'])->toHaveCount(1);
    expect($row['reactions'][0]['emoji'])->toBe($party);
    expect($row['reactions'][0]['mine'])->toBeTrue();
});

test('group and direct message reactions live in the same table', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);
    befriend($alice, $bob);

    $groupMessage = reactionMessage($group, $alice, 'In the group');
    $dm = reactionDirectMessage($bob, $alice, 'In private');
    $thumbsUp = "\u{1F44D}";

    test()->actingAs($bob)->postJson(route('member.community.messages.reaction', [$group, $groupMessage]), ['emoji' => $thumbsUp])->assertOk();
    test()->actingAs($bob)->postJson(route('member.friends.messages.reaction', [$alice, $dm]), ['emoji' => $thumbsUp])->assertOk();

    expect(MessageReaction::count())->toBe(2);
    expect(MessageReaction::pluck('message_type')->unique()->sort()->values()->all())
        ->toBe([CommunityGroupMessage::class, DirectMessage::class]);
});

test('reactions cannot cross direct message conversations', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $carol = reactionUser();
    befriend($alice, $bob);
    befriend($alice, $carol);

    // A private message between Bob and Carol.
    $bobToCarol = reactionDirectMessage($bob, $carol, 'Private');

    test()->actingAs($alice)
        ->postJson(route('member.friends.messages.reaction', [$bob, $bobToCarol]), ['emoji' => "\u{1F44D}"])
        ->assertNotFound();

    expect($bobToCarol->reactions()->count())->toBe(0);
});

test('non friends cannot react to direct messages', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $carol = reactionUser();
    befriend($bob, $carol);
    $message = reactionDirectMessage($bob, $carol);

    test()->actingAs($alice)
        ->postJson(route('member.friends.messages.reaction', [$bob, $message]), ['emoji' => "\u{1F44D}"])
        ->assertForbidden();

    expect($message->reactions()->count())->toBe(0);
});

test('reacting to your own message is allowed', function () {
    $alice = reactionUser();
    $group = reactionGroup($alice);
    $message = reactionMessage($group, $alice, 'Talking to myself');
    $laugh = "\u{1F602}";

    test()->actingAs($alice)
        ->postJson(route('member.community.messages.reaction', [$group, $message]), ['emoji' => $laugh])
        ->assertOk()
        ->assertJsonPath('reactions.0.mine', true);
});

test('reaction names are capped so one popular message cannot bloat the payload', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    $group = reactionGroup($alice);
    joinReactionGroup($group, $bob);
    $message = reactionMessage($group, $alice, 'Popular message');

    $message->reactions()->create(['user_id' => $alice->id, 'emoji' => "\u{1F44D}"]);
    $message->reactions()->create(['user_id' => $bob->id, 'emoji' => "\u{1F44D}"]);

    $row = test()->actingAs($alice)->getJson(route('member.community.messages', [$group]))->json('messages.0');

    expect($row['reactions'][0]['count'])->toBe(2);
    expect($row['reactions'][0]['names'])->toHaveCount(2);
});

test('deleting a message takes its reactions with it', function () {
    $alice = reactionUser();
    $group = reactionGroup($alice);
    $message = reactionMessage($group, $alice, 'Doomed message');

    $message->reactions()->create(['user_id' => $alice->id, 'emoji' => "\u{1F44D}"]);

    $message->delete();

    expect(MessageReaction::where('message_id', $message->id)->count())->toBe(0);
});

test('bulk deleting messages takes their reactions with them', function () {
    $alice = reactionUser();
    $group = reactionGroup($alice);
    $kept = reactionMessage($group, $alice, 'Stays');
    $first = reactionMessage($group, $alice, 'Goes first');
    $second = reactionMessage($group, $alice, 'Goes second');

    $first->reactions()->create(['user_id' => $alice->id, 'emoji' => "\u{1F44D}"]);
    $second->reactions()->create(['user_id' => $alice->id, 'emoji' => "\u{1F602}"]);
    $kept->reactions()->create(['user_id' => $alice->id, 'emoji' => "\u{1F44F}"]);

    test()->actingAs($alice)
        ->postJson(route('member.community.messages.delete', $group), ['ids' => [$first->id, $second->id]])
        ->assertOk()
        ->assertJsonPath('deleted', 2);

    expect(MessageReaction::whereIn('message_id', [$first->id, $second->id])->count())->toBe(0);
    // The surviving message keeps its own reaction.
    expect(MessageReaction::where('message_id', $kept->id)->count())->toBe(1);
});

test('bulk deleting direct messages takes their reactions with them', function () {
    $alice = reactionUser();
    $bob = reactionUser();
    befriend($alice, $bob);

    $kept = reactionDirectMessage($alice, $bob, 'Stays');
    $doomed = reactionDirectMessage($alice, $bob, 'Goes');
    $doomed->reactions()->create(['user_id' => $bob->id, 'emoji' => "\u{1F44D}"]);
    $kept->reactions()->create(['user_id' => $bob->id, 'emoji' => "\u{1F389}"]);

    test()->actingAs($alice)
        ->postJson(route('member.friends.messages.delete', $bob), ['ids' => [$doomed->id]])
        ->assertOk()
        ->assertJsonPath('deleted', 1);

    expect(MessageReaction::where('message_id', $doomed->id)->count())->toBe(0);
    expect(MessageReaction::where('message_id', $kept->id)->count())->toBe(1);
});
