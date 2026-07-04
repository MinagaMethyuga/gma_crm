<?php

use App\Models\Plan;
use App\Models\User;

test('expired members are redirected to pricing page', function () {
    $plan = Plan::create([
        'name' => 'Professional',
        'slug' => 'professional',
        'stripe_product_id' => 'prod_test',
        'stripe_price_id' => 'price_test',
        'price' => 99,
        'billing_period' => 'yearly',
    ]);

    // Create user with expired subscription (subscribed 2 years ago)
    $expiredUser = User::factory()->create([
        'plan_id' => $plan->id,
        'plan_subscribed_at' => now()->subYears(2),
        'role' => \App\Enums\UserRole::Member,
    ]);

    $response = $this->actingAs($expiredUser)->get(route('member.dashboard'));

    $response->assertRedirect(route('pricing'));
    $response->assertSessionHas('error');
});

test('active members can access dashboard', function () {
    $plan = Plan::create([
        'name' => 'Professional',
        'slug' => 'professional',
        'stripe_product_id' => 'prod_test_active',
        'stripe_price_id' => 'price_test_active',
        'price' => 99,
        'billing_period' => 'yearly',
    ]);

    $activeUser = User::factory()->create([
        'plan_id' => $plan->id,
        'plan_subscribed_at' => now()->subMonths(2),
        'role' => \App\Enums\UserRole::Member,
    ]);

    $response = $this->actingAs($activeUser)->get(route('member.dashboard'));

    $response->assertOk();
});

test('admins are not restricted by subscription check', function () {
    $adminUser = User::factory()->create([
        'role' => \App\Enums\UserRole::Admin,
        'plan_id' => null,
    ]);

    $response = $this->actingAs($adminUser)->get(route('dashboard'));

    $response->assertOk();
});
