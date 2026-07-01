<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'slug' => 'professional',
            'name' => 'Professional Membership',
            'subtitle' => 'Single user access',
            'description' => 'Webinars, research, networking, directory listing and event discounts',
            'price_one_time' => 49500,
            'price_monthly' => 49500,
            'price_yearly' => 49500,
        ]);

        Plan::create([
            'slug' => 'business',
            'name' => 'Business Membership',
            'subtitle' => 'Up to 5 users',
            'description' => 'Enhanced visibility, roundtables and working groups, early access to research and announcements, thought leadership contribution opportunities',
            'price_one_time' => 149500,
            'price_monthly' => 149500,
            'price_yearly' => 149500,
        ]);

        Plan::create([
            'slug' => 'strategic',
            'name' => 'Strategic Membership',
            'subtitle' => 'Up to 15 users',
            'description' => 'Sponsorship opportunities, featured member spotlights, strategic briefings, advisory participation opportunities',
            'price_one_time' => 299500,
            'price_monthly' => 299500,
            'price_yearly' => 299500,
        ]);
    }
}
