<?php

use App\Livewire\SettingsModal;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('settings modal renders with exact original ui and user data', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $this->actingAs($user);

    Livewire::test(SettingsModal::class)
        ->assertStatus(200)
        ->assertSee('Profile Settings')
        ->assertSee('John Doe')
        ->assertSee('john@example.com');
});

test('can update name and email inline from settings modal', function () {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    $this->actingAs($user);

    Livewire::test(SettingsModal::class)
        ->set('name', 'New Name')
        ->call('saveName')
        ->assertSee('Username updated successfully!')
        ->set('email', 'new@example.com')
        ->call('saveEmail')
        ->assertSee('Email updated successfully!');

    $user->refresh();

    expect($user->name)->toBe('New Name');
    expect($user->email)->toBe('new@example.com');
});

test('can upload avatar photo and save to user profile', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('avatar.jpg');

    Livewire::test(SettingsModal::class)
        ->set('newAvatar', $file)
        ->assertSee('Avatar photo updated successfully!');

    $user->refresh();

    expect($user->avatar)->not->toBeNull();
    Storage::disk('public')->assertExists($user->avatar);
    expect($user->avatarUrl())->toContain('storage/');
});
