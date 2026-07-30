<?php

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('staff cannot create categories menus or staff users', function () {
    $staff = User::factory()->create([
        'role' => User::ROLE_STAFF,
    ]);
    $category = Category::factory()->create();

    $this->actingAs($staff)
        ->get(route('categories.create'))
        ->assertForbidden();

    $this->actingAs($staff)
        ->post(route('categories.store'), [
            'name' => 'Staff Created Category',
            'description' => 'Should not be created by staff.',
        ])
        ->assertForbidden();

    $this->actingAs($staff)
        ->get(route('menus.create'))
        ->assertForbidden();

    $this->actingAs($staff)
        ->post(route('menus.store'), [
            'name' => 'Staff Created Menu',
            'description' => 'Should not be created by staff.',
            'price' => 12.50,
            'is_available' => true,
            'category_id' => $category->id,
        ])
        ->assertForbidden();

    $this->actingAs($staff)
        ->get(route('users.create'))
        ->assertForbidden();

    $this->actingAs($staff)
        ->post(route('users.store'), [
            'name' => 'New Staff',
            'email' => 'new.staff@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertForbidden();
});

test('staff can update order status', function () {
    $staff = User::factory()->create([
        'role' => User::ROLE_STAFF,
    ]);
    $order = Order::factory()->create([
        'customer_id' => Customer::factory(),
        'status' => Order::STATUS_PENDING,
        'notes' => 'Initial note.',
    ]);

    $this->actingAs($staff)
        ->put(route('orders.update', $order), [
            'status' => Order::STATUS_PREPARING,
            'notes' => 'Kitchen accepted the order.',
        ])
        ->assertRedirect(route('orders.edit', $order));

    expect($order->fresh())
        ->status->toBe(Order::STATUS_PREPARING)
        ->notes->toBe('Kitchen accepted the order.');
});

test('admin can create categories menus and staff users', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);

    $this->actingAs($admin)
        ->get(route('categories.create'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('menus.create'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('users.create'))
        ->assertOk();
});
