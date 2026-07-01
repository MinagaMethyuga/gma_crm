<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PlanSeeder::class);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gma.test',
            'password' => 'password',
            'role' => UserRole::Admin,
        ]);

        User::factory()->member()->create([
            'name' => 'Member User',
            'email' => 'member@gma.test',
            'password' => 'password',
        ]);
    }
}
