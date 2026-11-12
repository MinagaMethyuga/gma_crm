<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('community_group_messages', function (Blueprint $table) {
            $table->foreignId('reply_to_id')->nullable()->after('image')
                ->constrained('community_group_messages')->nullOnDelete();
            $table->foreignId('poll_id')->nullable()->after('reply_to_id')
                ->constrained('community_polls')->nullOnDelete();
            $table->string('type')->default('text')->after('poll_id');
            $table->timestamp('pinned_at')->nullable()->after('type');
            $table->foreignId('pinned_by')->nullable()->after('pinned_at')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('community_group_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reply_to_id');
            $table->dropConstrainedForeignId('poll_id');
            $table->dropColumn('type');
            $table->dropColumn('pinned_at');
            $table->dropConstrainedForeignId('pinned_by');
        });
    }
};
