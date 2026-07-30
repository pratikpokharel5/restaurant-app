<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('payments can be filtered by payment date', function () {
    $user = User::factory()->create();
    $todayCustomer = Customer::factory()->create([
        'name' => 'Today Customer',
    ]);
    $olderCustomer = Customer::factory()->create([
        'name' => 'Older Customer',
    ]);

    $todayOrder = Order::factory()->create([
        'customer_id' => $todayCustomer->id,
    ]);
    $olderOrder = Order::factory()->create([
        'customer_id' => $olderCustomer->id,
    ]);

    Payment::factory()->create([
        'order_id' => $todayOrder->id,
        'created_at' => now()->setDate(2026, 7, 30),
    ]);
    Payment::factory()->create([
        'order_id' => $olderOrder->id,
        'created_at' => now()->setDate(2026, 7, 29),
    ]);

    $this->actingAs($user)
        ->get(route('payments.index', ['payment_date' => '2026-07-30']))
        ->assertOk()
        ->assertSee('Today Customer')
        ->assertDontSee('Older Customer');
});
