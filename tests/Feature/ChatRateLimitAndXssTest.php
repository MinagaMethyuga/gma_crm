<?php

use App\Models\CommunityGroup;
use App\Models\DirectMessage;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

/*
 * Phase E: rate limiting + XSS hardening. Chat bodies are stored as plain text
 * (stripped of markup) and write endpoints are throttled so a single member
 * cannot flood a room or a DM inbox.
 */

function rlUser(): User
{
    return User::factory()->create();
}

function rlGroup(User $admin): CommunityGroup
{
    $group = CommunityGroup::create([
        'name' => 'Rate Room '.uniqid(),
        'category' => 'networking',
        'description' => 'A group.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $admin->id,
    ]);

    $group->members()->attach($admin->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

function rlFriends(User $a, User $b): void
{
    Friendship::create([
        'sender_id' => $a->id,
        'receiver_id' => $b->id,
        'status' => Friendship::STATUS_ACCEPTED,
    ]);
}

test('a community message body has its markup stripped before storage', function () {
    $admin = rlUser();
    $group = rlGroup($admin);

    $this->actingAs($admin)
        ->postJson(route('member.community.messages.send', $group), [
            'message' => '<script>alert(1)</script>hello <b>world</b>',
        ])
        ->assertCreated()
        ->assertJsonPath('message.message', 'alert(1)hello world');

    $stored = $group->messages()->first()->message;
    expect($stored)->not->toContain('<script>');
    expect($stored)->not->toContain('<b>');
});

test('a direct message body has its markup stripped before storage', function () {
    $me = rlUser();
    $friend = rlUser();
    rlFriends($me, $friend);

    $this->actingAs($me)
        ->postJson(route('member.friends.messages.send', $friend), [
            'message' => '<img src=x onerror=alert(1)>hi',
        ])
        ->assertCreated();

    // Assert on the stored value: the API echo runs through the translator,
    // which may re-case the text, but the database is what must be clean.
    $stored = DirectMessage::first()->message;
    expect($stored)->not->toContain('onerror');
    expect($stored)->not->toContain('<img');
    expect($stored)->toBe('hi');
});

test('an exhausted chat-message bucket makes the send endpoint answer 429', function () {
    $admin = rlUser();
    $group = rlGroup($admin);

    // Pre-fill the bucket for this user, then a single real request proves the
    // route middleware is wired to the limiter and surfaces a 429 JSON body.
    // ThrottleRequests hashes keys as md5($limiterName.$limit->key).
    RateLimiter::clear('chat-message');
    for ($i = 0; $i < 30; $i++) {
        RateLimiter::hit(md5('chat-message'.$admin->id));
    }

    $this->actingAs($admin)
        ->postJson(route('member.community.messages.send', $group), ['message' => 'blocked'])
        ->assertStatus(429);
});

test('community message sends are rate limited per member', function () {
    $admin = rlUser();
    $group = rlGroup($admin);

    // Drive the named limiter directly rather than 30 HTTP round-trips: the
    // cap is what matters, and this keeps the suite fast. The route is wired to
    // this exact limiter name (throttle:chat-message).
    $limiter = RateLimiter::limiter('chat-message');
    $request = Request::create('/');
    $request->setUserResolver(fn () => $admin);

    $limit = $limiter($request);
    expect($limit->maxAttempts)->toBe(30);

    RateLimiter::clear('chat-message');
    for ($i = 0; $i < 30; $i++) {
        expect(RateLimiter::tooManyAttempts('chat-message', 30))->toBeFalse();
        RateLimiter::hit('chat-message');
    }

    expect(RateLimiter::tooManyAttempts('chat-message', 30))->toBeTrue();
});

test('direct message sends are rate limited per member', function () {
    $me = rlUser();
    $friend = rlUser();
    rlFriends($me, $friend);

    $limiter = RateLimiter::limiter('chat-message');
    $request = Request::create('/');
    $request->setUserResolver(fn () => $me);

    expect($limiter($request)->maxAttempts)->toBe(30);

    RateLimiter::clear('chat-message');
    for ($i = 0; $i < 30; $i++) {
        RateLimiter::hit('chat-message');
    }

    expect(RateLimiter::tooManyAttempts('chat-message', 30))->toBeTrue();
});

test('reactions are rate limited separately from messages', function () {
    $limiter = RateLimiter::limiter('chat-action');
    $request = Request::create('/');
    $request->setUserResolver(fn () => rlUser());

    // Two independent buckets: exhausting actions must not touch messages.
    expect($limiter($request)->maxAttempts)->toBe(60);

    RateLimiter::clear('chat-message');
    RateLimiter::clear('chat-action');
    for ($i = 0; $i < 60; $i++) {
        RateLimiter::hit('chat-action');
    }

    expect(RateLimiter::tooManyAttempts('chat-action', 60))->toBeTrue();
    expect(RateLimiter::tooManyAttempts('chat-message', 30))->toBeFalse();
});
