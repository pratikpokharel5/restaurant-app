<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => fn () => Order::inRandomOrder()->first()?->id ?? Order::factory(),
            'menu_id' => fn () => Menu::inRandomOrder()->first()?->id ?? Menu::factory(),
            'quantity' => random_int(1, 5),
            'unit_price' => random_int(500, 10000) / 100,
        ];
    }
}
