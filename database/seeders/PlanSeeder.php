<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'slug' => 'professional',
                'name' => 'Professional Membership',
                'subtitle' => 'Single user access',
                'description' => 'Webinars, research, networking, directory listing and event discounts',
                'price_one_time' => 49500,
                'price_monthly' => 49500,
                'price_yearly' => 49500,
                'team_limit' => 1,
            ],
            [
                'slug' => 'business',
                'name' => 'Business Membership',
                'subtitle' => 'Up to 5 users',
                'description' => 'Enhanced visibility, roundtables and working groups, early access to research and announcements, thought leadership contribution opportunities',
                'price_one_time' => 149500,
                'price_monthly' => 149500,
                'price_yearly' => 149500,
                'team_limit' => 5,
            ],
            [
                'slug' => 'strategic',
                'name' => 'Strategic Membership',
                'subtitle' => 'Up to 15 users',
                'description' => 'Sponsorship opportunities, featured member spotlights, strategic briefings, advisory participation opportunities',
                'price_one_time' => 299500,
                'price_monthly' => 299500,
                'price_yearly' => 299500,
                'team_limit' => 15,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
