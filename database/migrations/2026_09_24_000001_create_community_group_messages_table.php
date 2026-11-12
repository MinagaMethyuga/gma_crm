<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_group_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->timestamps();

            $table->index('community_group_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_group_messages');
    }
};
