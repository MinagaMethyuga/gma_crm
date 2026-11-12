<?php

use App\Models\CommunityGroup;
use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'phone' => '1234567890',
        'company_name' => 'Acme Corp',
        'industry' => 'Tech',
        'physical_address' => '123 Main St',
        'company_website' => 'https://acme.org',
        'country' => 'US',
    ]);

    $user = User::where('email', 'test@example.com')->first();

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('pricing', absolute: false));

    $this->assertAuthenticated();
});

test('new users are automatically added to the official group', function () {
    $group = CommunityGroup::create([
        'name' => CommunityGroup::NAME_OFFICIAL,
        'slug' => CommunityGroup::SLUG_OFFICIAL,
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
    ]);

    $this->post(route('register.store'), [
        'name' => 'Grace Ndlovu',
        'email' => 'grace@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'phone' => '1234567890',
        'company_name' => 'Acme Corp',
        'industry' => 'Tech',
        'physical_address' => '123 Main St',
        'company_website' => 'https://acme.org',
        'country' => 'US',
    ])->assertSessionHasNoErrors();

    $user = User::where('email', 'grace@example.com')->firstOrFail();

    $membership = $group->fresh()->members()->find($user->id);

    expect($membership)->not->toBeNull()
        ->and($membership->pivot->role)->toBe('member');
});

test('registration still succeeds when the official group does not exist', function () {
    $this->post(route('register.store'), [
        'name' => 'Solo Founder',
        'email' => 'solo@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'phone' => '1234567890',
        'company_name' => 'Acme Corp',
        'industry' => 'Tech',
        'physical_address' => '123 Main St',
        'company_website' => 'https://acme.org',
        'country' => 'US',
    ])->assertSessionHasNoErrors();

    expect(User::where('email', 'solo@example.com')->exists())->toBeTrue()
        ->and(CommunityGroup::count())->toBe(0);
});
