<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('users index shows view user action', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);
    $staff = User::factory()->create([
        'role' => User::ROLE_STAFF,
    ]);

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertOk()
        ->assertSee($staff->name)
        ->assertSee('Actions')
        ->assertSee('View User')
        ->assertSee(route('users.show', $staff))
        ->assertDontSee('Archive this staff user?');
});

test('admin can view staff user detail page', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);
    $staff = User::factory()->create([
        'role' => User::ROLE_STAFF,
    ]);

    $this->actingAs($admin)
        ->get(route('users.show', $staff))
        ->assertOk()
        ->assertSee('View User')
        ->assertSee($staff->name)
        ->assertSee($staff->email)
        ->assertSee('Archive User');
});

test('staff cannot view another staff user detail page', function () {
    $staff = User::factory()->create([
        'role' => User::ROLE_STAFF,
    ]);
    $otherStaff = User::factory()->create([
        'role' => User::ROLE_STAFF,
    ]);

    $this->actingAs($staff)
        ->get(route('users.show', $otherStaff))
        ->assertForbidden();
});

test('admin can reset a staff password without current password', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);
    $staff = User::factory()->create([
        'role' => User::ROLE_STAFF,
        'password' => 'old-password',
    ]);

    $this->actingAs($admin)
        ->patch(route('users.password.update', $staff), [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertRedirect(route('users.show', $staff));

    expect(Hash::check('new-password', $staff->fresh()->password))->toBeTrue();
});

test('archive and restore actions stay on user detail page', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);
    $staff = User::factory()->create([
        'role' => User::ROLE_STAFF,
    ]);

    $this->actingAs($admin)
        ->patch(route('users.archive', $staff))
        ->assertRedirect(route('users.show', $staff));

    expect($staff->fresh()->isArchived())->toBeTrue();

    $this->actingAs($admin)
        ->patch(route('users.restore', $staff))
        ->assertRedirect(route('users.show', $staff));

    expect($staff->fresh()->isArchived())->toBeFalse();
});
