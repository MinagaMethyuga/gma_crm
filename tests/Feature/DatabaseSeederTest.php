<?php

use App\Models\CommunityGroup;
use App\Models\Plan;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

test('seeding creates the three administrators', function () {
    $this->seed(DatabaseSeeder::class);

    expect(User::where('email', 'dana@globalmobileassociation.biz')->exists())->toBeTrue()
        ->and(User::where('email', 'bob@globalmobileassociation.biz')->exists())->toBeTrue()
        ->and(User::where('email', 'admin2@gma.test')->exists())->toBeTrue();
});

test('seeding creates the official group as public and published', function () {
    $this->seed(DatabaseSeeder::class);

    $group = CommunityGroup::where('slug', CommunityGroup::SLUG_OFFICIAL)->first();

    expect($group)->not->toBeNull()
        ->and($group->name)->toBe('GMA Official')
        ->and($group->status)->toBe(CommunityGroup::STATUS_APPROVED)
        ->and($group->join_method)->toBe(CommunityGroup::JOIN_OPEN)
        ->and($group->is_private)->toBeFalse();
});

test('only dana and bob administer the official group', function () {
    $this->seed(DatabaseSeeder::class);

    $group = CommunityGroup::where('slug', CommunityGroup::SLUG_OFFICIAL)->first();

    $admins = $group->members()->wherePivot('role', 'admin')->pluck('users.email');

    expect($admins)
        ->toContain('dana@globalmobileassociation.biz')
        ->toContain('bob@globalmobileassociation.biz')
        ->not->toContain('admin2@gma.test')
        ->and($group->members()->count())->toBe(2);
});

test('admin2 is never enrolled in the official group', function () {
    $this->seed(DatabaseSeeder::class);

    $adminTwo = User::where('email', 'admin2@gma.test')->firstOrFail();
    $group = CommunityGroup::where('slug', CommunityGroup::SLUG_OFFICIAL)->first();

    expect($group->members()->whereKey($adminTwo->id)->exists())->toBeFalse();
});

test('seeding twice does not duplicate anything', function () {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    expect(User::whereIn('email', [
        'dana@globalmobileassociation.biz',
        'bob@globalmobileassociation.biz',
        'admin2@gma.test',
    ])->count())->toBe(3)
        ->and(CommunityGroup::where('slug', CommunityGroup::SLUG_OFFICIAL)->count())->toBe(1)
        ->and(Plan::count())->toBe(3);
});
