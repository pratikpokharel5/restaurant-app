<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Aarav Shrestha', 'email' => 'aarav.shrestha@example.com', 'phone' => '9801002001', 'address' => 'Lazimpat, Kathmandu'],
            ['name' => 'Nisha Gurung', 'email' => 'nisha.gurung@example.com', 'phone' => '9801002002', 'address' => 'Jhamsikhel, Lalitpur'],
            ['name' => 'Suman Karki', 'email' => 'suman.karki@example.com', 'phone' => '9801002003', 'address' => 'New Baneshwor, Kathmandu'],
            ['name' => 'Priya Maharjan', 'email' => 'priya.maharjan@example.com', 'phone' => '9801002004', 'address' => 'Patan Dhoka, Lalitpur'],
            ['name' => 'Rabin Thapa', 'email' => 'rabin.thapa@example.com', 'phone' => '9801002005', 'address' => 'Baluwatar, Kathmandu'],
            ['name' => 'Maya Lama', 'email' => 'maya.lama@example.com', 'phone' => '9801002006', 'address' => 'Boudha, Kathmandu'],
            ['name' => 'Kabir Adhikari', 'email' => 'kabir.adhikari@example.com', 'phone' => '9801002007', 'address' => 'Sanepa, Lalitpur'],
            ['name' => 'Anjali Rai', 'email' => 'anjali.rai@example.com', 'phone' => '9801002008', 'address' => 'Kapan, Kathmandu'],
            ['name' => 'Tenzin Sherpa', 'email' => 'tenzin.sherpa@example.com', 'phone' => '9801002009', 'address' => 'Bouddha, Kathmandu'],
            ['name' => 'Sneha Basnet', 'email' => 'sneha.basnet@example.com', 'phone' => '9801002010', 'address' => 'Maharajgunj, Kathmandu'],
            ['name' => 'Bibek KC', 'email' => 'bibek.kc@example.com', 'phone' => '9801002011', 'address' => 'Kupondole, Lalitpur'],
            ['name' => 'Ritika Joshi', 'email' => 'ritika.joshi@example.com', 'phone' => '9801002012', 'address' => 'Swayambhu, Kathmandu'],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['phone' => $customer['phone']],
                $customer + [
                    'user_role' => 'customer',
                    'password' => 'password',
                ]
            );
        }
    }
}
