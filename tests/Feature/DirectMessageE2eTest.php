<?php

use App\Models\ChatKey;
use App\Models\DirectMessage;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

/*
 * Phase C: end-to-end encrypted DMs. The server must never hold (or be able to
 * read) the message body for E2E rows; it only relays ciphertext, nonce and the
 * public keys that let peers derive their own shared secret.
 *
 * These tests use fake base64 blobs standing in for real WebCrypto output: the
 * server treats ciphertext as opaque, so the exact bytes do not matter here.
 */

function e2eUser(): User
{
    return User::factory()->create();
}

function e2eFriend(User $a, User $b): void
{
    Friendship::create([
        'sender_id' => $a->id,
        'receiver_id' => $b->id,
        'status' => Friendship::STATUS_ACCEPTED,
    ]);
}

test('a member can publish their public chat key', function () {
    $me = e2eUser();

    $this->actingAs($me)
        ->postJson(route('member.chat.keys.store'), ['public_key' => 'BASE64PUBKEY+abc/def='])
        ->assertOk()
        ->assertJsonPath('ok', true)
        ->assertJsonPath('key_version', 1);

    expect(ChatKey::where('user_id', $me->id)->value('public_key'))->toBe('BASE64PUBKEY+abc/def=');
});

test('publishing a different key rotates the version', function () {
    $me = e2eUser();

    $this->actingAs($me)
        ->postJson(route('member.chat.keys.store'), ['public_key' => 'first_key'])
        ->assertJsonPath('key_version', 1);

    $this->actingAs($me)
        ->postJson(route('member.chat.keys.store'), ['public_key' => 'second_key'])
        ->assertJsonPath('key_version', 2);

    $this->actingAs($me)
        ->postJson(route('member.chat.keys.store'), ['public_key' => 'second_key'])
        ->assertJsonPath('key_version', 2);
});

test('a published key must look like base64', function () {
    $me = e2eUser();

    $this->actingAs($me)
        ->postJson(route('member.chat.keys.store'), ['public_key' => 'not a key!!'])
        ->assertStatus(422);
});

test('a member can fetch a friends public key', function () {
    $me = e2eUser();
    $friend = e2eUser();
    e2eFriend($me, $friend);

    ChatKey::create(['user_id' => $friend->id, 'public_key' => 'friend_pub', 'key_version' => 3]);

    $this->actingAs($me)
        ->getJson(route('member.chat.keys.show', $friend))
        ->assertOk()
        ->assertJsonPath('public_key', 'friend_pub')
        ->assertJsonPath('key_version', 3);
});

test('a member cannot fetch a strangers public key', function () {
    $me = e2eUser();
    $stranger = e2eUser();

    ChatKey::create(['user_id' => $stranger->id, 'public_key' => 'stranger_pub']);

    $this->actingAs($me)
        ->getJson(route('member.chat.keys.show', $stranger))
        ->assertForbidden();
});

test('sending an encrypted message stores only ciphertext and leaves plaintext empty', function () {
    $me = e2eUser();
    $friend = e2eUser();
    e2eFriend($me, $friend);

    $this->actingAs($me)
        ->postJson(route('member.friends.messages.send', $friend), [
            'ciphertext' => 'ENCRYPTED_BODY_B64',
            'nonce' => 'NONCE_B64',
            'key_version' => 2,
        ])
        ->assertCreated()
        ->assertJsonPath('message.encrypted', true)
        ->assertJsonPath('message.message', null)
        ->assertJsonPath('message.nonce', 'NONCE_B64')
        ->assertJsonPath('message.key_version', 2)
        ->assertJsonPath('message.encrypted_peer_id', $friend->id);

    $raw = DB::table('direct_messages')->where('sender_id', $me->id)->first();

    expect($raw->message)->toBeNull();
    // The at-rest cast wraps the E2E ciphertext a second time, so the raw cell
    // is not the blob verbatim; decrypting it must recover the original.
    expect($raw->ciphertext)->not->toBe('ENCRYPTED_BODY_B64');
    expect(Crypt::decryptString($raw->ciphertext))->toBe('ENCRYPTED_BODY_B64');
    expect($raw->nonce)->toBe('NONCE_B64');
});

test('an encrypted message cannot also carry server-readable plaintext', function () {
    $me = e2eUser();
    $friend = e2eUser();
    e2eFriend($me, $friend);

    $this->actingAs($me)
        ->postJson(route('member.friends.messages.send', $friend), [
            'message' => 'plaintext leak',
            'ciphertext' => 'ENCRYPTED_BODY_B64',
            'nonce' => 'NONCE_B64',
        ])
        ->assertStatus(422);
});

test('an empty encrypted payload is rejected', function () {
    $me = e2eUser();
    $friend = e2eUser();
    e2eFriend($me, $friend);

    $this->actingAs($me)
        ->postJson(route('member.friends.messages.send', $friend), [])
        ->assertStatus(422);
});

test('the recipient receives the ciphertext payload to decrypt locally', function () {
    $me = e2eUser();
    $friend = e2eUser();
    e2eFriend($me, $friend);

    $this->actingAs($me)
        ->postJson(route('member.friends.messages.send', $friend), [
            'ciphertext' => 'ENCRYPTED_BODY_B64',
            'nonce' => 'NONCE_B64',
            'key_version' => 1,
        ])
        ->assertCreated();

    $this->actingAs($friend)
        ->getJson(route('member.friends.messages', $me))
        ->assertOk()
        ->assertJsonPath('messages.0.encrypted', true)
        ->assertJsonPath('messages.0.ciphertext', 'ENCRYPTED_BODY_B64')
        ->assertJsonPath('messages.0.encrypted_peer_id', $me->id);
});

test('a plaintext message still round-trips unchanged', function () {
    $me = e2eUser();
    $friend = e2eUser();
    e2eFriend($me, $friend);

    $this->actingAs($me)
        ->postJson(route('member.friends.messages.send', $friend), ['message' => 'hello friend'])
        ->assertCreated()
        ->assertJsonPath('message.encrypted', false)
        ->assertJsonPath('message.message', 'hello friend');

    $this->actingAs($friend)
        ->getJson(route('member.friends.messages', $me))
        ->assertJsonPath('messages.0.message', 'hello friend');
});

test('the direct message notification never leaks encrypted plaintext', function () {
    $me = e2eUser();
    $friend = e2eUser();
    e2eFriend($me, $friend);

    $this->actingAs($me)
        ->postJson(route('member.friends.messages.send', $friend), [
            'ciphertext' => 'ENCRYPTED_BODY_B64',
            'nonce' => 'NONCE_B64',
            'key_version' => 1,
        ])
        ->assertCreated();

    $this->actingAs($friend)
        ->getJson(route('member.notifications'))
        ->assertOk()
        ->assertJsonPath('notifications.0.data.preview', 'sent you a private message');
});

test('an encrypted message decrypts through the model for a legitimate reader', function () {
    $me = e2eUser();
    $friend = e2eUser();

    $dm = DirectMessage::create([
        'sender_id' => $me->id,
        'receiver_id' => $friend->id,
        'message' => null,
        'ciphertext' => 'SEALED',
        'nonce' => 'N1',
        'key_version' => 1,
    ]);

    expect($dm->fresh()->ciphertext)->toBe('SEALED');
    expect($dm->fresh()->message)->toBeNull();
    expect($dm->fresh()->isEncrypted())->toBeTrue();
});
