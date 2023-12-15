<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class OrderSeeder extends Seeder
{
    public function run()
    { // Seed data for the orders table
        $ordersData = [
            [
                'user_id' => 1,
                'name' => 'John Doe',
                'address' => '123 Main St',
                'phone' => '555-1234',
                'subtotal' => 50.00,
                'shipping_cost' => 5.00,
                'total_price' => 55.00,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
                'status' => 'Delivered'
            ],
            // Add more sample orders as needed
        ];

        // Insert seed data into the orders table
        $this->db->table('orders')->insertBatch($ordersData);
    }
}
