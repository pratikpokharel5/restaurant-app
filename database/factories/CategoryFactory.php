<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
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
            'name' => "Demo Category {$number}",
            'description' => "A demo category used for sample restaurant menus.",
        ];
    }
}
