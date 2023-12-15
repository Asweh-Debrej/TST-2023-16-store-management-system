<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CheckoutSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'products' => json_encode(["", "2", "3"]),

            ]

        ];

        $this->db->table('checkout')->insertBatch($data);
    }
}
