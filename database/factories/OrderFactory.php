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
        return [
            'customer_id' => fn () => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'total_price' => fake()->randomFloat(2, 10, 500),
            'status' => fake()->randomElement(Order::statuses()),
            'notes' => fake()->boolean(80) ? fake()->sentence() : null,
        ];
    }
}
