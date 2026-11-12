<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message_translations', function (Blueprint $table) {
            $table->id();
            $table->string('source_hash', 64);
            $table->string('source_language', 10)->nullable();
            $table->string('target_language', 10);
            $table->text('source_text');
            $table->text('translated_text');
            $table->timestamps();

            $table->unique(['source_hash', 'target_language']);
            $table->index('source_hash');
            $table->index(['target_language']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_translations');
    }
};
