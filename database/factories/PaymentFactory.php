<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Order;
use App\Models\Payment;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'amount' => function (array $attributes) {
                return Order::find($attributes['order_id'])->total_price;
            },
            'payment_method' => fake()->randomElement(['cash', 'online']),
            'status' => fake()->boolean(80),
        ];
    }
}
