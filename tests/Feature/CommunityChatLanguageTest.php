<?php

use App\Enums\UserRole;
use App\Models\CommunityGroup;
use App\Models\CommunityGroupMessage;
use App\Models\Plan;
use App\Models\User;

// Self-contained on purpose: these run in the same process as the other chat
// suites, so the names must not clash with theirs.
function chatLanguagePlan(): Plan
{
    return Plan::firstOrCreate(
        ['slug' => 'professional'],
        [
            'name' => 'Professional',
            'stripe_product_id' => 'prod_chat_language_test',
            'stripe_price_id' => 'price_chat_language_test',
            'price' => 99,
            'billing_period' => 'yearly',
        ]
    );
}

function chatLanguageUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'plan_id' => chatLanguagePlan()->id,
        'plan_subscribed_at' => now()->subMonth(),
        'role' => UserRole::Member,
    ], $overrides));
}

function chatLanguageGroup(User $creator): CommunityGroup
{
    $group = CommunityGroup::create([
        'name' => 'Language Group '.uniqid(),
        'category' => 'networking',
        'description' => 'A group for chatting.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $creator->id,
    ]);

    $group->members()->attach($creator->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

test('message timestamps follow the language the member chose', function () {
    $alice = chatLanguageUser(['preferred_language' => 'en']);
    $carlos = chatLanguageUser(['preferred_language' => 'es']);
    $group = chatLanguageGroup($alice);
    $group->members()->attach($carlos->id, ['role' => 'member', 'joined_at' => now()]);

    $message = $group->messages()->create([
        'user_id' => $alice->id,
        'message' => 'Hello there',
        'type' => CommunityGroupMessage::TYPE_TEXT,
    ]);

    $group->messages()->whereKey($message->id)->update(['created_at' => '2026-09-24 14:30:00']);

    test()->actingAs($alice)
        ->getJson(route('member.community.messages', $group))
        ->assertOk()
        ->assertJsonPath('messages.0.time', '2:30 PM');

    test()->actingAs($carlos)
        ->getJson(route('member.community.messages', $group))
        ->assertOk()
        ->assertJsonPath('messages.0.time', '2:30 p. m.');
});

test('member join dates follow the language the member chose', function () {
    $alice = chatLanguageUser(['preferred_language' => 'en']);
    $carlos = chatLanguageUser(['preferred_language' => 'fr']);
    $group = chatLanguageGroup($alice);
    $group->members()->attach($carlos->id, ['role' => 'member', 'joined_at' => '2026-09-24 14:30:00']);

    // The group creator is always listed first, so Carlos is second.
    test()->actingAs($alice)
        ->getJson(route('member.community.members', $group))
        ->assertOk()
        ->assertJsonPath('members.1.joined_at', 'Sep 24, 2026');

    test()->actingAs($carlos)
        ->getJson(route('member.community.members', $group))
        ->assertOk()
        ->assertJsonPath('members.1.joined_at', 'sept. 24, 2026');
});

test('message timestamps fall back to english for members with no language', function () {
    $alice = chatLanguageUser(['preferred_language' => 'en']);
    $newcomer = chatLanguageUser(['preferred_language' => null]);
    $group = chatLanguageGroup($alice);
    $group->members()->attach($newcomer->id, ['role' => 'member', 'joined_at' => now()]);

    $group->messages()->create([
        'user_id' => $alice->id,
        'message' => 'Hello there',
        'type' => CommunityGroupMessage::TYPE_TEXT,
    ]);

    $group->messages()->latest('id')->limit(1)->update(['created_at' => '2026-09-24 14:30:00']);

    test()->actingAs($newcomer)
        ->getJson(route('member.community.messages', $group))
        ->assertOk()
        ->assertJsonPath('messages.0.time', '2:30 PM');
});
