<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'role' => User::ROLE_ADMIN,
            'password' => Hash::make(env('ADMIN_PASSWORD', 'qwertyasdf')),
        ]);

        User::factory()->create([
            'name' => 'Kitchen Staff',
            'email' => 'kitchen@test.com',
            'role' => User::ROLE_STAFF,
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Counter Staff',
            'email' => 'counter@test.com',
            'role' => User::ROLE_STAFF,
            'password' => Hash::make('password'),
        ]);
    }
}
