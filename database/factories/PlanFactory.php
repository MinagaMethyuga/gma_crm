<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'price_monthly' => $this->faker->numberBetween(500, 10000),
            'price_yearly' => $this->faker->numberBetween(5000, 100000),
        ];
    }
}
