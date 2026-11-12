<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Group chat and direct message bubbles share one reaction table, so a
        // message is addressed polymorphically rather than duplicated per chat.
        Schema::create('message_reactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('message');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('emoji', 16);
            $table->timestamps();

            // One row per member per emoji, which is what makes the toggle safe.
            $table->unique(['message_type', 'message_id', 'user_id', 'emoji'], 'message_reactions_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_reactions');
    }
};
