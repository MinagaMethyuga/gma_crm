<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('member')->after('current_team_id');
            $table->string('member_type')->nullable()->after('role');
            $table->string('phone')->nullable()->after('member_type');
            $table->string('company_name')->nullable()->after('phone');
            $table->string('industry')->nullable()->after('company_name');
            $table->string('job_title')->nullable()->after('industry');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'member_type', 'phone', 'company_name', 'industry', 'job_title']);
        });
    }
};
