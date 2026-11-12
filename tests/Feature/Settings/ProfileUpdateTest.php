<?php

use App\Data\Countries;
use App\Data\Languages;
use App\Models\User;
use Livewire\Livewire;

test('profile page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get(route('profile.edit'))->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.profile')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User');
    expect($user->email)->toEqual('test@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.profile')
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('organization information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::settings.profile')
        ->set('company_name', 'Cell Revolution')
        ->set('industry', 'Telecommunications')
        ->set('job_title', 'CEO')
        ->set('phone', '0722144466')
        ->set('physical_address', '1 Main Street')
        ->set('company_website', 'https://example.com')
        ->set('country', 'AT')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    $user->refresh();

    expect($user->company_name)->toEqual('Cell Revolution');
    expect($user->industry)->toEqual('Telecommunications');
    expect($user->job_title)->toEqual('CEO');
    expect($user->phone)->toEqual('0722144466');
    expect($user->physical_address)->toEqual('1 Main Street');
    expect($user->company_website)->toEqual('https://example.com');
    expect($user->country)->toEqual('AT');
});

test('organization information is optional', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::settings.profile')
        ->set('name', 'Test User')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();
});

test('country must be a known country code', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::settings.profile')
        ->set('country', 'ZZ')
        ->call('updateProfileInformation')
        ->assertHasErrors(['country']);
});

test('country codes resolve to readable names', function () {
    expect(Countries::name('AT'))->toEqual('Austria');
    expect(Countries::name('us'))->toEqual('United States');
    expect(Countries::name('United States'))->toEqual('United States');
    expect(Countries::name(null))->toBeNull();
    expect(Countries::name(''))->toBeNull();
});

test('the community chat locale falls back to english for unknown languages', function () {
    $user = User::factory()->create(['preferred_language' => 'ZZ']);

    expect($user->preferredLanguage())->toEqual('en');
    expect($user->preferredLocale())->toEqual('en');
});

test('language tags resolve to a carbon locale', function () {
    expect(Languages::resolve('es'))->toEqual('es');
    expect(Languages::resolve(null))->toEqual('en');
    expect(Languages::resolve(''))->toEqual('en');
    expect(Languages::resolve('ZZ'))->toEqual('en');
    expect(Languages::name('es'))->toEqual('Español');
    expect(Languages::name('ZZ'))->toEqual('ZZ');
    expect(Languages::name(null))->toBeNull();
    expect(Languages::carbonLocale('no'))->toEqual('nb');
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.delete-user-modal')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($user->fresh())->toBeNull();
    expect(auth()->check())->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.delete-user-modal')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});
