<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
            CustomerSeeder::class,
        ]);

        // Create orders for 80 customers
        $customersWithOrders = Customer::inRandomOrder()->limit(80)->get();

        foreach ($customersWithOrders as $customer) {
            // Create 1 to 3 orders for each customer
            $orders = Order::factory(rand(1, 3))->create([
                'customer_id' => $customer->id,
            ]);

            foreach ($orders as $order) {
                // Attach 1 to 5 random order items
                $menus = Menu::inRandomOrder()->limit(rand(1, 5))->get();

                $totalPrice = 0;

                foreach ($menus as $menu) {
                    $qty = rand(1, 4);

                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'menu_id' => $menu->id,
                        'quantity' => $qty,
                        'unit_price' => $menu->price,
                    ]);

                    $totalPrice += ($menu->price * $qty);
                }

                $status = fake()->randomElement([
                    'pending',
                    'preparing',
                    'on_the_way',
                    'delivered',
                    'cancelled'
                ]);

                $order->update([
                    'total_price' => $totalPrice,
                    'status' => $status
                ]);

                Payment::factory()->create([
                    'order_id' => $order->id,
                    'amount' => $totalPrice,
                    'status' => $status === 'delivered'
                ]);
            }
        }
    }
}
