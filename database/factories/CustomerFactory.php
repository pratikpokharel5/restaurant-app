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
            'name' => "Demo Customer {$number}",
            'email' => "demo.customer.{$number}@example.com",
            'phone' => '980200'.str_pad((string) $number, 4, '0', STR_PAD_LEFT),
            'address' => "Demo Address {$number}, Kathmandu",
            'user_role' => 'customer',
            'password' => static::$password ??= Hash::make('password'),
        ];
    }
}
