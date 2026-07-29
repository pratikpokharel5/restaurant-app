<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Breakfast', 'description' => 'Morning service items for dine-in and takeaway guests.'],
            ['name' => 'Starters', 'description' => 'Small plates prepared quickly before mains.'],
            ['name' => 'Momo & Dumplings', 'description' => 'Steamed, fried, and jhol momo varieties.'],
            ['name' => 'Rice & Noodles', 'description' => 'Filling mains from the wok and rice station.'],
            ['name' => 'Curries', 'description' => 'House curries served with rice or roti.'],
            ['name' => 'Breads & Sides', 'description' => 'Add-ons that complete a table order.'],
            ['name' => 'Desserts', 'description' => 'Sweet items served after meals.'],
            ['name' => 'Beverages', 'description' => 'Hot drinks, cold drinks, and fresh juices.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
