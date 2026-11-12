<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('community_groups', function (Blueprint $table) {
            $table->boolean('admin_only_messages')->default(false);
            $table->unsignedSmallInteger('message_cooldown_count')->nullable();
            $table->unsignedSmallInteger('message_cooldown_minutes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('community_groups', function (Blueprint $table) {
            $table->dropColumn(['admin_only_messages', 'message_cooldown_count', 'message_cooldown_minutes']);
        });
    }
};
