<?php

use App\Enums\UserRole;
use App\Models\CommunityGroup;
use App\Models\CommunityMessageReport;
use App\Models\DirectMessage;
use App\Models\Friendship;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// Helpers are prefixed so they cannot collide with the other chat suites
// running in the same process.
function sqliPlan(): Plan
{
    return Plan::firstOrCreate(
        ['slug' => 'professional'],
        [
            'name' => 'Professional',
            'stripe_product_id' => 'prod_sqli_test',
            'stripe_price_id' => 'price_sqli_test',
            'price' => 99,
            'billing_period' => 'yearly',
        ]
    );
}

function sqliUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'plan_id' => sqliPlan()->id,
        'plan_subscribed_at' => now()->subMonth(),
        'role' => UserRole::Member,
    ], $overrides));
}

function sqliGroup(User $creator): CommunityGroup
{
    $group = CommunityGroup::create([
        'name' => 'SQLi Group '.uniqid(),
        'category' => 'networking',
        'description' => 'Injection attempts land here.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $creator->id,
    ]);

    $group->members()->attach($creator->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

function sqliBefriend(User $a, User $b): void
{
    Friendship::create([
        'sender_id' => $a->id,
        'receiver_id' => $b->id,
        'status' => Friendship::STATUS_ACCEPTED,
    ]);
}

/**
 * Classic injection probes. Every one must be treated as an ordinary string:
 * no 500s, no leaking rows the caller should not see.
 */
function sqliPayloads(): array
{
    return [
        "1' OR '1'='1",
        "1' OR 1=1 --",
        "'; DROP TABLE users; --",
        "' UNION SELECT id, email, password FROM users --",
        "admin'--",
        "%' OR 'x'='x",
        "1' AND SLEEP(5)--",
        "ZZZ' OR users.role='admin' --",
    ];
}

test('friend search treats sql injection payloads as literal text', function () {
    $me = sqliUser();
    $admin = User::factory()->create(['role' => UserRole::Admin, 'name' => 'Real Admin']);

    foreach (sqliPayloads() as $payload) {
        $response = $this->actingAs($me)
            ->getJson(route('member.friends.search', ['q' => $payload]))
            ->assertSuccessful();

        // Either the validator rejects it or zero users match; never the
        // whole user table (which an injected OR 1=1 would return).
        expect($response->json('results'))->toBeArray();
        expect(count($response->json('results')))->toBeLessThanOrEqual(1);
    }

    expect(User::count())->toBeGreaterThan(1);
});

test('friend search does not expose admin rows through injected or-clauses', function () {
    $me = sqliUser();
    User::factory()->create(['role' => UserRole::Admin, 'name' => 'Target Admin']);

    $response = $this->actingAs($me)
        ->getJson(route('member.friends.search', ['q' => "x' OR role='admin' --"]))
        ->assertSuccessful();

    expect($response->json('results'))->toBeEmpty();
});

test('search wildcard characters cannot broaden a like match', function () {
    $me = sqliUser();
    User::factory()->create(['name' => 'Nothing', 'email' => 'nothing@example.com']);

    // "%" alone is below the 2-character minimum; "%_" must not match
    // every row the way an unescaped LIKE pattern would.
    $response = $this->actingAs($me)
        ->getJson(route('member.friends.search', ['q' => '%_']))
        ->assertSuccessful();

    expect($response->json('results'))->toBeEmpty();
});

test('sql payloads in community messages are stored and returned verbatim', function () {
    $author = sqliUser();
    $member = sqliUser();
    $group = sqliGroup($author);
    $group->members()->attach($member->id, ['role' => 'member', 'joined_at' => now()]);

    $payload = "Robert'); DROP TABLE community_group_messages; --";

    $this->actingAs($author)
        ->postJson(route('member.community.messages.send', [$group]), ['message' => $payload])
        ->assertCreated()
        ->assertJsonPath('message.message', $payload);

    $response = $this->actingAs($member)
        ->getJson(route('member.community.messages', [$group]))
        ->assertOk();

    expect(collect($response->json('messages'))->pluck('message'))->toContain($payload);

    // The table survived and holds exactly one row.
    expect(DB::table('community_group_messages')->count())->toBe(1);
});

test('sql payloads in direct messages are stored and returned verbatim', function () {
    $alice = sqliUser();
    $bob = sqliUser();
    sqliBefriend($alice, $bob);

    $payload = "' UNION SELECT sender_id, receiver_id FROM direct_messages --";

    $this->actingAs($alice)
        ->postJson(route('member.friends.messages.send', [$bob]), ['message' => $payload])
        ->assertCreated()
        ->assertJsonPath('message.message', $payload);

    $response = $this->actingAs($bob)
        ->getJson(route('member.friends.messages', [$alice]))
        ->assertOk();

    expect(collect($response->json('messages'))->pluck('message'))->toContain($payload);
    expect(DB::table('direct_messages')->count())->toBe(1);
});

test('bulk delete rejects non integer ids instead of interpolating them', function () {
    $alice = sqliUser();
    $bob = sqliUser();
    sqliBefriend($alice, $bob);

    DirectMessage::create([
        'sender_id' => $alice->id,
        'receiver_id' => $bob->id,
        'message' => 'Keep me',
    ]);

    $this->actingAs($alice)
        ->postJson(route('member.friends.messages.delete', [$bob]), [
            'ids' => ['1 OR 1=1', '0; DELETE FROM direct_messages; --'],
        ])
        ->assertStatus(422);

    expect(DB::table('direct_messages')->count())->toBe(1);
});

test('report details store sql payloads as plain text', function () {
    $author = sqliUser();
    $reporter = sqliUser();
    $group = sqliGroup($author);
    $group->members()->attach($reporter->id, ['role' => 'member', 'joined_at' => now()]);

    $message = $group->messages()->create([
        'user_id' => $author->id,
        'message' => 'Ordinary message',
        'type' => 'text',
    ]);

    $details = "1'; UPDATE users SET role='admin'; --";

    $this->actingAs($reporter)
        ->postJson(route('member.community.messages.report', [$group, $message]), [
            'reason' => 'spam',
            'details' => $details,
        ])
        ->assertSuccessful();

    $report = CommunityMessageReport::first();
    expect($report->details)->toBe($details);

    // Nobody was promoted.
    expect(User::where('role', UserRole::Admin)->count())->toBe(0);
});

test('report reason whitelist rejects injected values', function () {
    $author = sqliUser();
    $reporter = sqliUser();
    $group = sqliGroup($author);
    $group->members()->attach($reporter->id, ['role' => 'member', 'joined_at' => now()]);

    $message = $group->messages()->create([
        'user_id' => $author->id,
        'message' => 'Ordinary message',
        'type' => 'text',
    ]);

    $this->actingAs($reporter)
        ->postJson(route('member.community.messages.report', [$group, $message]), [
            'reason' => "spam' OR '1'='1",
            'details' => 'nope',
        ])
        ->assertStatus(422);

    expect(CommunityMessageReport::count())->toBe(0);
});
