<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        Payment::query()->delete();
        OrderItem::query()->delete();
        Order::query()->delete();

        $orders = [
            [
                'customer_phone' => '9801002001',
                'status' => Order::STATUS_PENDING,
                'notes' => 'No onion in momo achar. Customer will pick up from counter.',
                'payment_method' => 'cash',
                'paid' => false,
                'created_at' => now()->subMinutes(18),
                'items' => [
                    ['Chicken Steam Momo', 2],
                    ['Fresh Lemon Soda', 2],
                ],
            ],
            [
                'customer_phone' => '9801002002',
                'status' => Order::STATUS_PREPARING,
                'notes' => 'Table 6. Serve starters first.',
                'payment_method' => 'cash',
                'paid' => false,
                'created_at' => now()->subMinutes(42),
                'items' => [
                    ['Paneer Pakora', 1],
                    ['Paneer Butter Masala', 1],
                    ['Garlic Naan', 2],
                    ['Masala Tea', 2],
                ],
            ],
            [
                'customer_phone' => '9801002003',
                'status' => Order::STATUS_ON_THE_WAY,
                'notes' => 'Delivery to New Baneshwor gate. Call before arrival.',
                'payment_method' => 'online',
                'paid' => true,
                'created_at' => now()->subHour(),
                'items' => [
                    ['Butter Chicken', 1],
                    ['Steamed Rice', 2],
                    ['Mixed Pickle', 1],
                ],
            ],
            [
                'customer_phone' => '9801002004',
                'status' => Order::STATUS_DELIVERED,
                'notes' => 'Regular customer. Extra achar provided.',
                'payment_method' => 'online',
                'paid' => true,
                'created_at' => now()->subHours(3),
                'items' => [
                    ['Buff Jhol Momo', 2],
                    ['Mango Lassi', 2],
                    ['Gulab Jamun', 1],
                ],
            ],
            [
                'customer_phone' => '9801002005',
                'status' => Order::STATUS_CANCELLED,
                'notes' => 'Customer cancelled before kitchen accepted the order.',
                'payment_method' => 'cash',
                'paid' => false,
                'created_at' => now()->subHours(4),
                'items' => [
                    ['Chicken Chowmein', 1],
                    ['Americano', 1],
                ],
            ],
            [
                'customer_phone' => '9801002006',
                'status' => Order::STATUS_DELIVERED,
                'notes' => 'Packed separately for office lunch.',
                'payment_method' => 'online',
                'paid' => true,
                'created_at' => now()->subDay(),
                'items' => [
                    ['Chicken Curry Thali', 3],
                    ['Fresh Lemon Soda', 3],
                ],
            ],
            [
                'customer_phone' => '9801002007',
                'status' => Order::STATUS_PREPARING,
                'notes' => 'Make dal tadka mild.',
                'payment_method' => 'cash',
                'paid' => false,
                'created_at' => now()->subMinutes(27),
                'items' => [
                    ['Dal Tadka', 1],
                    ['Butter Naan', 3],
                    ['Kheer', 1],
                ],
            ],
            [
                'customer_phone' => '9801002008',
                'status' => Order::STATUS_PENDING,
                'notes' => 'Customer requested bill at counter.',
                'payment_method' => 'cash',
                'paid' => false,
                'created_at' => now()->subMinutes(9),
                'items' => [
                    ['Veg Kothey Momo', 1],
                    ['Egg Fried Rice', 1],
                ],
            ],
            [
                'customer_phone' => '9801002009',
                'status' => Order::STATUS_DELIVERED,
                'notes' => 'Family dinner order.',
                'payment_method' => 'online',
                'paid' => true,
                'created_at' => now()->subDays(2),
                'items' => [
                    ['Chicken Chilli Momo', 2],
                    ['Mixed Thukpa', 2],
                    ['Chocolate Brownie', 2],
                ],
            ],
            [
                'customer_phone' => '9801002010',
                'status' => Order::STATUS_ON_THE_WAY,
                'notes' => 'Office delivery. Ask security for Sneha.',
                'payment_method' => 'online',
                'paid' => true,
                'created_at' => now()->subMinutes(75),
                'items' => [
                    ['Veg Fried Rice', 4],
                    ['Crispy Corn', 2],
                    ['Masala Tea', 4],
                ],
            ],
        ];

        foreach ($orders as $orderData) {
            $customer = Customer::where('phone', $orderData['customer_phone'])->firstOrFail();
            $totalPrice = 0;

            $order = Order::create([
                'customer_id' => $customer->id,
                'total_price' => 0,
                'status' => $orderData['status'],
                'notes' => $orderData['notes'],
                'created_at' => $orderData['created_at'],
                'updated_at' => $orderData['created_at']->copy()->addMinutes(12),
            ]);

            foreach ($orderData['items'] as [$menuName, $quantity]) {
                $menu = Menu::where('name', $menuName)->firstOrFail();
                $totalPrice += $menu->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $quantity,
                    'unit_price' => $menu->price,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);

            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'payment_method' => $orderData['payment_method'],
                'status' => $orderData['paid'],
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }
}
