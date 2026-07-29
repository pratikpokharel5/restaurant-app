<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->boolean(80) ? $this->faker->unique()->safeEmail() : null,
            'phone' => $this->faker->unique()->phoneNumber(),
            'address' => $this->faker->boolean(80) ? $this->faker->address() : null,
            'user_role' => 'customer',
            'password' => static::$password ??= Hash::make('password'),
        ];
    }
}
