<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['Breakfast', 'Masala Omelette', 'Two eggs with onion, tomato, coriander, and toasted bread.', 180, true],
            ['Breakfast', 'Aloo Paratha Set', 'Stuffed paratha served with curd, pickle, and butter.', 240, true],
            ['Breakfast', 'Pancake with Honey', 'Three soft pancakes finished with honey and seasonal fruit.', 260, true],
            ['Starters', 'Crispy Corn', 'Golden fried corn tossed with pepper, chilli, and spring onion.', 220, true],
            ['Starters', 'Chicken Choila', 'Smoky grilled chicken mixed with Nepali spices and beaten rice.', 360, true],
            ['Starters', 'Paneer Pakora', 'Paneer fritters with mint chutney.', 280, true],
            ['Starters', 'French Fries', 'Crispy potato fries with house seasoning.', 190, true],
            ['Momo & Dumplings', 'Chicken Steam Momo', 'Ten pieces served with tomato sesame achar.', 260, true],
            ['Momo & Dumplings', 'Buff Jhol Momo', 'Buff momo served in warm sesame tomato broth.', 310, true],
            ['Momo & Dumplings', 'Veg Kothey Momo', 'Pan-fried vegetable momo with spicy achar.', 250, true],
            ['Momo & Dumplings', 'Chicken Chilli Momo', 'Fried momo tossed with capsicum, onion, and chilli sauce.', 340, true],
            ['Rice & Noodles', 'Chicken Chowmein', 'Wok-fried noodles with chicken and seasonal vegetables.', 290, true],
            ['Rice & Noodles', 'Veg Fried Rice', 'Rice tossed with vegetables, egg optional on request.', 240, true],
            ['Rice & Noodles', 'Mixed Thukpa', 'Noodle soup with chicken, egg, vegetables, and herbs.', 330, true],
            ['Rice & Noodles', 'Egg Fried Rice', 'Fried rice with scrambled egg and spring onion.', 250, true],
            ['Curries', 'Butter Chicken', 'Creamy tomato chicken curry finished with butter.', 520, true],
            ['Curries', 'Paneer Butter Masala', 'Paneer simmered in rich tomato cashew gravy.', 450, true],
            ['Curries', 'Chicken Curry Thali', 'Chicken curry with rice, dal, greens, achar, and papad.', 480, true],
            ['Curries', 'Dal Tadka', 'Yellow lentils tempered with ghee, garlic, and cumin.', 260, true],
            ['Breads & Sides', 'Butter Naan', 'Soft tandoor naan brushed with butter.', 95, true],
            ['Breads & Sides', 'Garlic Naan', 'Naan topped with garlic, coriander, and butter.', 125, true],
            ['Breads & Sides', 'Steamed Rice', 'Single portion of steamed long-grain rice.', 120, true],
            ['Breads & Sides', 'Mixed Pickle', 'House achar portion for sharing.', 70, true],
            ['Desserts', 'Gulab Jamun', 'Two warm milk dumplings in cardamom syrup.', 180, true],
            ['Desserts', 'Kheer', 'Rice pudding with cardamom, raisins, and nuts.', 160, true],
            ['Desserts', 'Chocolate Brownie', 'Warm brownie served with vanilla ice cream.', 300, false],
            ['Beverages', 'Masala Tea', 'Milk tea brewed with ginger and house spice mix.', 80, true],
            ['Beverages', 'Fresh Lemon Soda', 'Lemon soda served sweet, salty, or mixed.', 140, true],
            ['Beverages', 'Mango Lassi', 'Thick yogurt drink blended with mango.', 190, true],
            ['Beverages', 'Americano', 'Fresh espresso topped with hot water.', 170, true],
        ];

        foreach ($menus as [$categoryName, $name, $description, $price, $isAvailable]) {
            $category = Category::where('name', $categoryName)->firstOrFail();

            Menu::updateOrCreate(
                ['name' => $name],
                [
                    'description' => $description,
                    'price' => $price,
                    'is_available' => $isAvailable,
                    'category_id' => $category->id,
                ]
            );
        }
    }
}
