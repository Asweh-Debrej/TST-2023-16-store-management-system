<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DrinksSeeder extends Seeder
{
  public function run()
  {
    $data = [
      [
        'gambar'  => 'eskopisusu.png',
        'produk'  => 'Es Kopi Susu',
        'harga'   => '15000',
        'kuantitas' => 1,
        'created_at' => Time::now(),
        'updated_at' => Time::now()
      ],
      [
        'gambar'  => 'eslatte.png',
        'produk'  => 'Es Latte',
        'harga'   => '12000',
        'kuantitas' => 1,
        'created_at' => Time::now(),
        'updated_at' => Time::now()
      ],
      [
        'gambar'  => 'esamericano.png',
        'produk'  => 'Es Americano',
        'harga'   => '17000',
        'kuantitas' => 1,
        'created_at' => Time::now(),
        'updated_at' => Time::now()
      ],
      [
        'gambar'  => 'esmatcha.png',
        'produk'  => 'Es Matcha',
        'harga'   => '25000',
        'kuantitas' => 1,
        'created_at' => Time::now(),
        'updated_at' => Time::now()
      ],
      [
        'gambar'  => 'eschocolate.png',
        'produk'  => 'Es Chocolate',
        'harga'   => '25000',
        'kuantitas' => 1,
        'created_at' => Time::now(),
        'updated_at' => Time::now()
      ],
      [
        'gambar'  => 'esredvelvet.png',
        'produk'  => 'Es Red Velvet',
        'harga'   => '25000',
        'kuantitas' => 1,
        'created_at' => Time::now(),
        'updated_at' => Time::now()
      ],
    ];

    // // Simple Queries
    // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

    // Using Query Builder
    $this->db->table('drinks')->insertBatch($data);
  }
}
