<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('orders can be filtered by order date', function () {
    $user = User::factory()->create();
    $todayCustomer = Customer::factory()->create([
        'name' => 'Today Order Customer',
    ]);
    $olderCustomer = Customer::factory()->create([
        'name' => 'Older Order Customer',
    ]);

    Order::factory()->create([
        'customer_id' => $todayCustomer->id,
        'created_at' => now()->setDate(2026, 7, 30),
    ]);
    Order::factory()->create([
        'customer_id' => $olderCustomer->id,
        'created_at' => now()->setDate(2026, 7, 29),
    ]);

    $this->actingAs($user)
        ->get(route('orders.index', ['order_date' => '2026-07-30']))
        ->assertOk()
        ->assertSee('Today Order Customer')
        ->assertDontSee('Older Order Customer');
});
