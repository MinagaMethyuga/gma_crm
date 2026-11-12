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
        Schema::table('community_groups', function (Blueprint $table) {
            $table->string('join_method')->default('open')->after('is_private');
            $table->index('join_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_groups', function (Blueprint $table) {
            $table->dropIndex(['join_method']);
            $table->dropColumn('join_method');
        });
    }
};
