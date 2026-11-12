<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_message_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('community_group_message_id')->nullable()
                ->constrained('community_group_messages')->nullOnDelete();
            $table->foreignId('reported_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->string('reason');
            $table->text('details')->nullable();
            $table->text('message_snapshot')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['community_group_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_message_reports');
    }
};
