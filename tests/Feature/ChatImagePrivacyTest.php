<?php

use App\Models\CommunityGroup;
use App\Models\DirectMessage;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

/*
 * Phase D: private chat image storage. Attachments are written to the private
 * `local` disk and can only be read through access-checked stream routes, so a
 * leaked path alone does not expose a member's photo.
 */

function imgBytes(): string
{
    return base64_decode(
        'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAzSURBVFhH7c6hAQAwCMAwzsLz/Z4angPARNRUJSrfvyzm2A4AAAAAAAAAAAAAAAAAAKABzAEQiMPnMF0AAAAASUVORK5CYII='
    );
}

function imgUpload(string $name = 'photo.png'): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, imgBytes());
}

function imgUser(): User
{
    return User::factory()->create();
}

function imgGroup(User $admin): CommunityGroup
{
    $group = CommunityGroup::create([
        'name' => 'Photo Room '.uniqid(),
        'category' => 'networking',
        'description' => 'A group for photos.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $admin->id,
    ]);

    $group->members()->attach($admin->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

function imgFriends(User $a, User $b): void
{
    Friendship::create([
        'sender_id' => $a->id,
        'receiver_id' => $b->id,
        'status' => Friendship::STATUS_ACCEPTED,
    ]);
}

test('community images are stored on the private disk, not the webroot', function () {
    Storage::fake('local');
    Storage::fake('public');

    $admin = imgUser();
    $group = imgGroup($admin);

    $this->actingAs($admin)
        ->post(route('member.community.messages.send', $group), ['image' => imgUpload()])
        ->assertCreated();

    $stored = collect(Storage::disk('local')->allFiles('community-messages'));
    expect($stored)->toHaveCount(1);

    Storage::disk('public')->assertMissing($stored->first());
});

test('a group member can stream a community image', function () {
    Storage::fake('local');

    $admin = imgUser();
    $member = imgUser();
    $group = imgGroup($admin);
    $group->members()->attach($member->id, ['role' => 'member', 'joined_at' => now()]);

    $response = $this->actingAs($admin)
        ->post(route('member.community.messages.send', $group), ['image' => imgUpload()])
        ->assertCreated();

    $this->actingAs($member)
        ->get(route('member.community.messages.image', $response->json('message.id')))
        ->assertOk()
        ->assertHeader('Content-Type', 'image/png');
});

test('a non-member cannot stream a community image', function () {
    Storage::fake('local');

    $admin = imgUser();
    $outsider = imgUser();
    $group = imgGroup($admin);

    $response = $this->actingAs($admin)
        ->post(route('member.community.messages.send', $group), ['image' => imgUpload()])
        ->assertCreated();

    $this->actingAs($outsider)
        ->get(route('member.community.messages.image', $response->json('message.id')))
        ->assertForbidden();
});

test('a party to a DM can stream the image but a stranger cannot', function () {
    Storage::fake('local');

    $me = imgUser();
    $friend = imgUser();
    $stranger = imgUser();
    imgFriends($me, $friend);

    $response = $this->actingAs($me)
        ->post(route('member.friends.messages.send', $friend), ['image' => imgUpload()])
        ->assertCreated();

    $id = $response->json('message.id');

    $this->actingAs($friend)
        ->get(route('member.friends.messages.image', $id))
        ->assertOk()
        ->assertHeader('Content-Type', 'image/png');

    $this->actingAs($stranger)
        ->get(route('member.friends.messages.image', $id))
        ->assertForbidden();
});

test('the image payload points at the access-checked route not a raw path', function () {
    Storage::fake('local');

    $admin = imgUser();
    $group = imgGroup($admin);

    $response = $this->actingAs($admin)
        ->post(route('member.community.messages.send', $group), ['image' => imgUpload()])
        ->assertCreated();

    $url = $response->json('message.image_url');

    expect($url)->toContain('/image');
    expect($url)->not->toContain('/storage/');
});

test('an image message can still carry an encrypted body', function () {
    Storage::fake('local');

    $me = imgUser();
    $friend = imgUser();
    imgFriends($me, $friend);

    $this->actingAs($me)
        ->post(route('member.friends.messages.send', $friend), [
            'ciphertext' => 'SEALED_IMG_CAPTION',
            'nonce' => 'NONCE_B64',
            'key_version' => 1,
            'image' => imgUpload(),
        ])
        ->assertCreated()
        ->assertJsonPath('message.encrypted', true);

    $raw = DirectMessage::where('sender_id', $me->id)->first();
    expect($raw->message)->toBeNull();
    expect($raw->ciphertext)->not->toBeNull();
    expect($raw->image)->not->toBeNull();
});
