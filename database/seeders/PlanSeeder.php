<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'slug' => 'starter',
            'name' => 'Starter',
            'description' => 'Great for small businesses and startups looking to get started with AI',
            'price_monthly' => 1200,
            'price_yearly' => 9900,
        ]);

        Plan::create([
            'slug' => 'business',
            'name' => 'Business',
            'description' => 'Best value for growing businesses that need more advanced features',
            'price_monthly' => 4800,
            'price_yearly' => 39900,
        ]);

        Plan::create([
            'slug' => 'enterprise',
            'name' => 'Enterprise',
            'description' => 'Advanced plan with enhanced security and unlimited access for large teams',
            'price_monthly' => 9600,
            'price_yearly' => 89900,
        ]);
    }
}
