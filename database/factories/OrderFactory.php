<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Order;
use App\Models\Customer;

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
            'customer_id' => fn() => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'total_price' => fake()->randomFloat(2, 10, 500),
            'status' => fake()->randomElement(['pending', 'preparing', 'on_the_way', 'delivered', 'cancelled']),
            'notes' => fake()->boolean(80) ? fake()->sentence() : null,
        ];
    }
}
