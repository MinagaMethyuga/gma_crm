<?php

use App\Enums\UserRole;
use App\Models\CommunityGroup;
use App\Models\CommunityGroupMessage;
use App\Models\CommunityMessageReport;
use App\Models\DirectMessage;
use App\Models\MessageTranslation;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/*
 * Phase B: encryption-at-rest. The casts are transparent on the way out, so
 * every existing "chat works" behaviour keeps passing unchanged. These tests
 * pin the part that IS new: the plaintext never reaches the database, and the
 * backfill that protects rows written before the casts existed.
 *
 * They assert against the raw DB layer on purpose; reading through Eloquent
 * would just exercise the decrypting cast and prove nothing about the disk.
 */

function atRestUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'plan_id' => atRestPlan()->id,
        'plan_subscribed_at' => now()->subMonth(),
        'role' => UserRole::Member,
    ], $overrides));
}

function atRestPlan(): Plan
{
    return Plan::firstOrCreate(
        ['slug' => 'professional'],
        [
            'name' => 'Professional',
            'stripe_product_id' => 'prod_at_rest',
            'stripe_price_id' => 'price_at_rest',
            'price' => 99,
            'billing_period' => 'yearly',
        ]
    );
}

function atRestGroup(User $admin): CommunityGroup
{
    $group = CommunityGroup::create([
        'name' => 'Encrypted Room '.uniqid(),
        'category' => 'networking',
        'description' => 'A group for chatting.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $admin->id,
    ]);

    $group->members()->attach($admin->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

function atRestJoin(CommunityGroup $group, User $user, string $role = 'member'): void
{
    $group->members()->attach($user->id, ['role' => $role, 'joined_at' => now()]);
}

/** Posts through the real endpoint, which is what fans the notification out. */
function atRestSend(CommunityGroup $group, User $author, string $body): CommunityGroupMessage
{
    $response = test()->actingAs($author)
        ->postJson(route('member.community.messages.send', [$group]), ['message' => $body])
        ->assertCreated();

    return $group->messages()->findOrFail($response->json('message.id'));
}

test('community group message bodies are encrypted at rest but readable via the model', function () {
    $admin = atRestUser();
    $group = atRestGroup($admin);

    $message = $group->messages()->create([
        'user_id' => $admin->id,
        'message' => 'Buy leads off the dark web',
        'type' => CommunityGroupMessage::TYPE_TEXT,
    ]);

    $raw = DB::table('community_group_messages')->where('id', $message->id)->value('message');

    expect($raw)->not->toBe('Buy leads off the dark web');
    expect(Crypt::decryptString((string) $raw))->toBe('Buy leads off the dark web');
    expect($message->fresh()->message)->toBe('Buy leads off the dark web');
});

test('community message bodies are never indexed as plaintext', function () {
    $admin = atRestUser();
    $group = atRestGroup($admin);

    $group->messages()->create([
        'user_id' => $admin->id,
        'message' => 'super-secret-password',
        'type' => CommunityGroupMessage::TYPE_TEXT,
    ]);

    $found = CommunityGroupMessage::where('message', 'super-secret-password')->exists();

    expect($found)->toBeFalse();
    expect(DB::table('community_group_messages')->count())->toBe(1);
});

test('direct message bodies are encrypted at rest but readable via the model', function () {
    $sender = atRestUser();
    $receiver = atRestUser();

    $dm = DirectMessage::create([
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'message' => 'Let’s meet after hours',
    ]);

    $raw = DB::table('direct_messages')->where('id', $dm->id)->value('message');

    expect($raw)->not->toBe('Let’s meet after hours');
    expect(Crypt::decryptString((string) $raw))->toBe('Let’s meet after hours');
    expect($dm->fresh()->message)->toBe('Let’s meet after hours');
});

test('community message report snapshots and details are encrypted at rest', function () {
    $admin = atRestUser();
    $group = atRestGroup($admin);
    $message = $group->messages()->create([
        'user_id' => $admin->id,
        'message' => 'Reported body',
        'type' => CommunityGroupMessage::TYPE_TEXT,
    ]);

    $report = CommunityMessageReport::create([
        'community_group_id' => $group->id,
        'community_group_message_id' => $message->id,
        'reporter_id' => $admin->id,
        'reason' => CommunityMessageReport::REASON_SPAM,
        'details' => 'Bought a domain from them',
        'message_snapshot' => 'Reported body',
    ]);

    $raw = DB::table('community_message_reports')->where('id', $report->id)->first();

    expect($raw->details)->not->toBe('Bought a domain from them');
    expect($raw->message_snapshot)->not->toBe('Reported body');

    expect(Crypt::decryptString($raw->details))->toBe('Bought a domain from them');
    expect(Crypt::decryptString($raw->message_snapshot))->toBe('Reported body');

    expect($report->fresh()->details)->toBe('Bought a domain from them');
    expect($report->fresh()->message_snapshot)->toBe('Reported body');
});

test('message translation source and result are encrypted at rest', function () {
    $translation = MessageTranslation::create([
        'source_hash' => str_repeat('a', 64),
        'source_language' => 'en',
        'target_language' => 'es',
        'source_text' => 'Where is the nearest embassy?',
        'translated_text' => '¿Dónde está la embajada más cercana?',
    ]);

    $raw = DB::table('message_translations')->where('id', $translation->id)->first();

    expect($raw->source_text)->not->toBe('Where is the nearest embassy?');
    expect($raw->translated_text)->not->toBe('¿Dónde está la embajada más cercana?');

    expect(Crypt::decryptString($raw->source_text))->toBe('Where is the nearest embassy?');
    expect(Crypt::decryptString($raw->translated_text))->toBe('¿Dónde está la embajada más cercana?');
});

test('the translation cache lookup still works off the plaintext hash', function () {
    $hash = hash('sha256', 'en|es|Hello world');

    MessageTranslation::create([
        'source_hash' => $hash,
        'source_language' => 'en',
        'target_language' => 'es',
        'source_text' => 'Hello world',
        'translated_text' => 'Hola mundo',
    ]);

    $cached = MessageTranslation::where('source_hash', $hash)->first();

    expect($cached)->not->toBeNull();
    expect($cached->translated_text)->toBe('Hola mundo');
});

test('the notification pipeline stores encrypted data the API can still decode', function () {
    $admin = atRestUser();
    $member = atRestUser();
    $group = atRestGroup($admin);
    atRestJoin($group, $member);

    $message = atRestSend($group, $admin, 'encrypted hello');

    $raw = DB::table('notifications')->where('type', 'like', '%CommunityGroupMessage%')->first();
    expect($raw)->not->toBeNull();

    expect(Crypt::decryptString($raw->data))->toContain('"preview":"encrypted hello"');

    $this->actingAs($member)
        ->getJson(route('member.notifications'))
        ->assertOk()
        ->assertJsonPath('notifications.0.data.preview', 'encrypted hello');

    expect($message->exists)->toBeTrue();
});

test('the backfill migration encrypts legacy plaintext rows', function () {
    $admin = atRestUser();

    $oldMessageId = DB::table('community_group_messages')->insertGetId([
        'community_group_id' => atRestGroup($admin)->id,
        'user_id' => $admin->id,
        'message' => 'legacy plaintext body',
        'type' => CommunityGroupMessage::TYPE_TEXT,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $notificationId = (string) Str::uuid();
    DB::table('notifications')->insert([
        'id' => $notificationId,
        'type' => 'App\\Notifications\\CommunityGroupMessageNotification',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id' => $admin->id,
        'data' => json_encode(['type' => 'group_message', 'preview' => 'legacy preview']),
        'read_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $translationId = DB::table('message_translations')->insertGetId([
        'source_hash' => str_repeat('b', 64),
        'source_language' => 'en',
        'target_language' => 'fr',
        'source_text' => 'legacy source',
        'translated_text' => 'legacy result',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    (require __DIR__.'/../../database/migrations/2026_10_08_000001_encrypt_chat_content_at_rest.php')->up();

    $rawMessage = DB::table('community_group_messages')->where('id', $oldMessageId)->value('message');
    expect($rawMessage)->not->toBe('legacy plaintext body');
    expect(Crypt::decryptString($rawMessage))->toBe('legacy plaintext body');

    $rawData = DB::table('notifications')->where('id', $notificationId)->value('data');
    expect(Crypt::decryptString($rawData))->toContain('"preview":"legacy preview"');

    $rawTranslation = DB::table('message_translations')->where('id', $translationId)->first();
    expect(Crypt::decryptString($rawTranslation->source_text))->toBe('legacy source');
    expect(Crypt::decryptString($rawTranslation->translated_text))->toBe('legacy result');
});

test('the backfill migration is idempotent and does not re-encrypt ciphertext', function () {
    $admin = atRestUser();
    $group = atRestGroup($admin);

    $id = DB::table('community_group_messages')->insertGetId([
        'community_group_id' => $group->id,
        'user_id' => $admin->id,
        'message' => 'stays encrypted once',
        'type' => CommunityGroupMessage::TYPE_TEXT,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $migration = require __DIR__.'/../../database/migrations/2026_10_08_000001_encrypt_chat_content_at_rest.php';

    $migration->up();
    $once = DB::table('community_group_messages')->where('id', $id)->value('message');

    $migration->up();
    $twice = DB::table('community_group_messages')->where('id', $id)->value('message');

    expect($twice)->toBe($once);
    expect(Crypt::decryptString($twice))->toBe('stays encrypted once');
});
