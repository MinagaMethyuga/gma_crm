<?php

use App\Models\DirectMessage;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('debug ids two', function () {
    $a = User::factory()->create();
    $b = User::factory()->create();
    Friendship::create(['sender_id' => $a->id, 'receiver_id' => $b->id, 'status' => 'accepted']);
    DirectMessage::create(['sender_id' => $a->id, 'receiver_id' => $b->id, 'message' => 'Keep me']);
    $r = $this->actingAs($a)->postJson(route('member.friends.messages.delete', [$b]), ['ids' => ['1 OR 1=1', '0; DELETE FROM direct_messages; --']]);
    dump('status', $r->status());
    expect(true)->toBeTrue();
});
