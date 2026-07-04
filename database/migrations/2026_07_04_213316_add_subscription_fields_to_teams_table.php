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
        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('plan_subscribed_at')->nullable();
            $table->integer('max_seats')->nullable();
            $table->string('subscription_status')->nullable();
            $table->string('stripe_checkout_session_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn([
                'plan_id', 
                'plan_subscribed_at', 
                'max_seats', 
                'subscription_status', 
                'stripe_checkout_session_id'
            ]);
        });
    }
};
