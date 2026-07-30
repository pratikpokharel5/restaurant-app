<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('archived staff users see a deactivated account message when credentials are valid', function () {
    $user = User::factory()->create([
        'email' => 'archived.staff@example.com',
        'password' => 'password',
        'archived_at' => now(),
    ]);

    $response = $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertSessionHasErrors([
            'email' => 'Your account has been deactivated. Please contact an administrator for access.',
        ])
        ->assertSessionHasInput('email', $user->email);

    $this->assertGuest();
});

test('invalid login still shows the generic invalid credentials message', function () {
    User::factory()->create([
        'email' => 'active.staff@example.com',
        'password' => 'password',
    ]);

    $response = $this->post(route('login.store'), [
        'email' => 'active.staff@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors([
        'email' => 'Invalid email or password. Please try again.',
    ]);

    $this->assertGuest();
});

test('archived logged in users are logged out on the next request', function () {
    $user = User::factory()->create([
        'archived_at' => null,
    ]);

    $this->actingAs($user);

    $user->archive();

    $this->get(route('dashboard'))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'Your account has been deactivated. Please contact an administrator for access.',
        ]);

    $this->assertGuest();
});
