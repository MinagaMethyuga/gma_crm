<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('direct_messages', function (Blueprint $table) {
            // End-to-end encrypted body. When present the plaintext `message`
            // column is left NULL, so the server only relays opaque ciphertext.
            $table->text('ciphertext')->nullable()->after('message');
            // Base64 AES-GCM nonce paired with the ciphertext above.
            $table->text('nonce')->nullable()->after('ciphertext');
            // Bumped when the recipient rotates keys; lets a client detect a
            // message it can no longer decrypt after a rotation.
            $table->unsignedInteger('key_version')->nullable()->after('nonce');
        });

        // `message` was NOT NULL; an E2E row keeps it NULL and stores ciphertext
        // instead, so it must become nullable.
        Schema::table('direct_messages', function (Blueprint $table) {
            $table->text('message')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('direct_messages', function (Blueprint $table) {
            $table->dropColumn(['ciphertext', 'nonce', 'key_version']);
        });
    }
};
