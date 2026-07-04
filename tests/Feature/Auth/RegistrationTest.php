<?php

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