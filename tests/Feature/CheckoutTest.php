<?php

use App\Models\Order;
use App\Models\Plan;
use App\Models\User;

test('checkout success marks order paid and updates user plan', function () {
    $user = User::factory()->create(['plan_id' => null]);
    $plan = Plan::create([
        'name' => 'Professional',
        'slug' => 'professional',
        'stripe_product_id' => 'prod_test',
        'stripe_price_id' => 'price_test',
        'price' => 99,
        'billing_period' => 'yearly',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'plan_period' => 'yearly',
        'amount' => 9900,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($user)->get(route('checkout.success'));

    $response->assertOk();
    expect($order->fresh()->status)->toBe('paid');
    expect($user->fresh()->plan_id)->toBe($plan->id);
    expect($user->fresh()->plan_subscribed_at)->not->toBeNull();
});
