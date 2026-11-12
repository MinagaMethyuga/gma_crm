<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_poll_id')->constrained('community_polls')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('option_index');
            $table->timestamps();

            $table->unique(['community_poll_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_poll_votes');
    }
};
