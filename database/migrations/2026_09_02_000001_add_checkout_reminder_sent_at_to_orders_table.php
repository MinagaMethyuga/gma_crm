<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('checkout_reminder_1_sent_at')->nullable()->after('stripe_payment_intent');
            $table->timestamp('checkout_reminder_2_sent_at')->nullable()->after('checkout_reminder_1_sent_at');
            $table->timestamp('checkout_reminder_3_sent_at')->nullable()->after('checkout_reminder_2_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['checkout_reminder_1_sent_at', 'checkout_reminder_2_sent_at', 'checkout_reminder_3_sent_at']);
        });
    }
};