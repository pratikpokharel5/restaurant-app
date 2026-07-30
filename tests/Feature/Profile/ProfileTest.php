<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('authenticated users can view their profile page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('My Profile')
        ->assertSee($user->email);
});

test('users can update their name without changing password', function () {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'staff@example.com',
        'password' => 'password',
    ]);

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'changed@example.com',
        ])
        ->assertRedirect(route('profile.edit'));

    $user->refresh();

    expect($user)
        ->name->toBe('New Name')
        ->email->toBe('staff@example.com');

    expect(Hash::check('password', $user->password))->toBeTrue();
});

test('admin cannot update their name from profile page', function () {
    $admin = User::factory()->create([
        'name' => 'Main Admin',
        'role' => User::ROLE_ADMIN,
    ]);

    $this->actingAs($admin)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Name cannot be changed.');

    $this->actingAs($admin)
        ->patch(route('profile.update'), [
            'name' => 'Changed Admin',
        ])
        ->assertRedirect(route('profile.edit'));

    expect($admin->fresh()->name)->toBe('Main Admin');
});

test('users can change their password with current password', function () {
    $user = User::factory()->create([
        'password' => 'password',
    ]);

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => $user->name,
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertRedirect(route('profile.edit'));

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('users must provide current password before changing password', function () {
    $user = User::factory()->create([
        'password' => 'password',
    ]);

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => $user->name,
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertSessionHasErrors('current_password');

    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});
