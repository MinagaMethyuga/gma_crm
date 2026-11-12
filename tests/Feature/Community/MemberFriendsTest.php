<?php

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function actingMember(): User
{
    $user = User::factory()->create();
    test()->actingAs($user);

    return $user;
}

test('friends can be searched by name', function () {
    actingMember();

    User::factory()->create(['name' => 'Zelda Fitzgerald', 'email' => 'zelda@example.com']);

    $this->getJson(route('member.friends.search', ['q' => 'Zelda']))
        ->assertOk()
        ->assertJsonCount(1, 'results')
        ->assertJsonPath('results.0.email', 'zelda@example.com');
});

test('friends can be searched by email', function () {
    actingMember();

    User::factory()->create(['name' => 'Someone Else', 'email' => 'findme@example.com']);

    $this->getJson(route('member.friends.search', ['q' => 'findme@']))
        ->assertOk()
        ->assertJsonCount(1, 'results')
        ->assertJsonPath('results.0.email', 'findme@example.com');
});

test('search returns the current friendship status', function () {
    $me = actingMember();
    $friend = User::factory()->create(['name' => 'Connected Person']);
    $pending = User::factory()->create(['name' => 'Pending Person']);
    $incoming = User::factory()->create(['name' => 'Incoming Person']);

    Friendship::create(['sender_id' => $me->id, 'receiver_id' => $friend->id, 'status' => Friendship::STATUS_ACCEPTED]);
    Friendship::create(['sender_id' => $me->id, 'receiver_id' => $pending->id, 'status' => Friendship::STATUS_PENDING]);
    Friendship::create(['sender_id' => $incoming->id, 'receiver_id' => $me->id, 'status' => Friendship::STATUS_PENDING]);

    $response = $this->getJson(route('member.friends.search', ['q' => 'Person']))->assertOk();

    $statuses = collect($response->json('results'))->pluck('friend_status', 'name');

    expect($statuses['Connected Person'])->toBe('friends');
    expect($statuses['Pending Person'])->toBe('pending_sent');
    expect($statuses['Incoming Person'])->toBe('pending_received');
});

test('search never returns the current user', function () {
    $me = actingMember();
    $me->update(['name' => 'Searchable McSelf']);

    $this->getJson(route('member.friends.search', ['q' => 'Searchable']))
        ->assertOk()
        ->assertJsonCount(0, 'results');
});

test('search requires at least two characters', function () {
    actingMember();

    $this->getJson(route('member.friends.search', ['q' => 'a']))->assertStatus(422);

    $this->getJson(route('member.friends.search'))->assertStatus(422);
});

test('guests cannot search for members', function () {
    $this->get(route('member.friends.search', ['q' => 'test']))
        ->assertRedirect(route('login'));
});

test('a friend request can be sent to a searched member', function () {
    actingMember();

    $target = User::factory()->create(['email' => 'target@example.com']);

    $this->postJson(route('member.friends.request', $target))
        ->assertOk()
        ->assertJsonPath('friend_status', 'pending_sent');

    expect(Friendship::where('sender_id', auth()->id())->where('receiver_id', $target->id)->exists())->toBeTrue();
});

test('inbox lists incoming and outgoing requests separately', function () {
    $me = actingMember();
    $from = User::factory()->create(['name' => 'Inbound Person', 'email' => 'in@example.com']);
    $to = User::factory()->create(['name' => 'Outbound Person', 'email' => 'out@example.com']);

    Friendship::create(['sender_id' => $from->id, 'receiver_id' => $me->id, 'status' => Friendship::STATUS_PENDING]);
    Friendship::create(['sender_id' => $me->id, 'receiver_id' => $to->id, 'status' => Friendship::STATUS_PENDING]);
    Friendship::create(['sender_id' => $me->id, 'receiver_id' => User::factory()->create()->id, 'status' => Friendship::STATUS_ACCEPTED]);

    $this->getJson(route('member.friends.requests'))
        ->assertOk()
        ->assertJsonCount(1, 'incoming')
        ->assertJsonCount(1, 'outgoing')
        ->assertJsonPath('incoming_count', 1)
        ->assertJsonPath('incoming.0.user.email', 'in@example.com')
        ->assertJsonPath('incoming.0.direction', 'incoming')
        ->assertJsonPath('outgoing.0.user.email', 'out@example.com')
        ->assertJsonPath('outgoing.0.direction', 'outgoing');
});

test('inbox is empty when there are no requests', function () {
    actingMember();

    $this->getJson(route('member.friends.requests'))
        ->assertOk()
        ->assertJsonCount(0, 'incoming')
        ->assertJsonCount(0, 'outgoing')
        ->assertJsonPath('incoming_count', 0);
});

test('inbox does not leak other members requests', function () {
    $me = actingMember();
    $other = User::factory()->create();
    $stranger = User::factory()->create();

    Friendship::create(['sender_id' => $stranger->id, 'receiver_id' => $other->id, 'status' => Friendship::STATUS_PENDING]);

    $this->getJson(route('member.friends.requests'))
        ->assertOk()
        ->assertJsonCount(0, 'incoming')
        ->assertJsonCount(0, 'outgoing');
});

test('accepting from the inbox moves the request to friends', function () {
    $me = actingMember();
    $from = User::factory()->create();

    Friendship::create(['sender_id' => $from->id, 'receiver_id' => $me->id, 'status' => Friendship::STATUS_PENDING]);

    $this->postJson(route('member.friends.accept', $from))->assertOk();

    expect(Friendship::where('sender_id', $from->id)->where('receiver_id', $me->id)->first()->status)
        ->toBe(Friendship::STATUS_ACCEPTED);

    $this->getJson(route('member.friends.requests'))
        ->assertJsonCount(0, 'incoming')
        ->assertJsonPath('incoming_count', 0);
});

test('declining from the inbox removes the request', function () {
    $me = actingMember();
    $from = User::factory()->create();

    Friendship::create(['sender_id' => $from->id, 'receiver_id' => $me->id, 'status' => Friendship::STATUS_PENDING]);

    $this->postJson(route('member.friends.decline', $from))->assertOk();

    expect(Friendship::where('sender_id', $from->id)->where('receiver_id', $me->id)->exists())->toBeFalse();
});

test('guests cannot open the inbox', function () {
    $this->get(route('member.friends.requests'))->assertRedirect(route('login'));
});
