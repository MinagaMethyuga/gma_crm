<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\CommunityGroup;
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

        $dana = $this->adminUser('Dana Dorcas', 'dana@globalmobileassociation.biz', 'Associationtime73#!');

        $bob = $this->adminUser('Bob Lafon', 'bob@globalmobileassociation.biz', 'BobBobtime10#$');

        // Deliberately not added to the official community group.
        $this->adminUser('Admin User 2', 'admin2@gma.test', 'testadmin#!@');

        $this->createOfficialGroup($dana, $bob);
    }

    
    /**
     * Create an administrator, reusing the existing account if already present
     * so the seeder can be run more than once.
     */
    private function adminUser(string $name, string $email, string $password): User
    {
        return User::where('email', $email)->first() ?? User::factory()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => UserRole::Admin,
        ]);
    }

    /**
     * Create the official association group and enrol its administrators.
     *
     * Model events are silenced for seeders, so the slug and privacy flag are
     * set explicitly rather than relying on the CommunityGroup boot hooks.
     */
    private function createOfficialGroup(User $dana, User $bob): void
    {
        $group = CommunityGroup::firstOrCreate(
            ['slug' => CommunityGroup::SLUG_OFFICIAL],
            [
                'name' => CommunityGroup::NAME_OFFICIAL,
                'category' => CommunityGroup::CATEGORY_GENERAL,
                'description' => 'The official Global Mobile Association group. Every member is added automatically on registration.',
                'join_method' => CommunityGroup::JOIN_OPEN,
                'is_private' => false,
                'status' => CommunityGroup::STATUS_APPROVED,
                'created_by' => $dana->id,
            ]
        );

        $group->members()->syncWithoutDetaching([
            $dana->id => ['role' => 'admin', 'joined_at' => now()],
            $bob->id => ['role' => 'admin', 'joined_at' => now()],
        ]);
    }
}
