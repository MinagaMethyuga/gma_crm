<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Dana Dorcas',
            'email' => 'dana@globalmobileassociation.biz',
            'password' => Hash::make('Associationtime73#!'),
            'role' => UserRole::Admin,
        ]);

        User::factory()->create([
            'name' => 'Bob Lafon',
            'email' => 'bob@globalmobileassociation.biz',
            'password' => Hash::make('BobBobtime10#$'),
            'role' => UserRole::Admin,
        ]);

        User::factory()->create([
            'name' => 'Admin User 2',
            'email' => 'admin2@gma.test',
            'password' => Hash::make('testadmin#!@'),
            'role' => UserRole::Admin,
        ]);
    }
}