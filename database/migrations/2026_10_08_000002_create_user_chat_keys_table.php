<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_chat_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Raw ECDH public key (base64 SPKI). The matching private key never
            // leaves the browser, so the server only ever relays public material.
            $table->text('public_key');
            // Lets a reader pick the right key material after a rotation.
            $table->unsignedInteger('key_version')->default(1);
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_chat_keys');
    }
};
