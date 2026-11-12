<?php

namespace App\Actions\Community;

use App\Models\CommunityGroup;
use App\Models\User;

class JoinOfficialGroup
{
    /**
     * Enrol a user in the official association group.
     *
     * Every member is added automatically when they register. Safe to call
     * repeatedly: an existing membership keeps its current role and join date.
     */
    public function handle(User $user, string $role = 'member'): void
    {
        $group = CommunityGroup::where('slug', CommunityGroup::SLUG_OFFICIAL)->first();

        if (! $group) {
            return;
        }

        $group->members()->syncWithoutDetaching([
            $user->id => ['role' => $role, 'joined_at' => now()],
        ]);
    }
}
