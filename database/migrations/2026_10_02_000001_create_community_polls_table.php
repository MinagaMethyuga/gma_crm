<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_polls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('question');
            $table->json('options');
            $table->boolean('allow_multiple')->default(false);
            $table->timestamp('closes_at')->nullable();
            $table->timestamps();

            $table->index('community_group_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_polls');
    }
};
