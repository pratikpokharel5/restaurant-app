<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    protected static int $number = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = ++static::$number;

        return [
            'name' => "Demo Menu {$number}",
            'description' => "A demo menu item for restaurant testing.",
            'price' => random_int(500, 10000) / 100,
            'is_available' => random_int(1, 100) <= 80,
            'category_id' => fn () => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }
}
