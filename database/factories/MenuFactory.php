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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 5, 100),
            'is_available' => fake()->boolean(80),
            'category_id' => fn () => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }
}
