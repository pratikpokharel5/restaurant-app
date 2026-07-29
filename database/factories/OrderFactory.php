<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = Order::statuses();

        return [
            'customer_id' => fn () => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'total_price' => random_int(1000, 50000) / 100,
            'status' => $statuses[array_rand($statuses)],
            'notes' => random_int(1, 100) <= 80 ? 'Demo order note for kitchen staff.' : null,
        ];
    }
}
