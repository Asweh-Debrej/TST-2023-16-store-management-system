<?php

namespace App\Controllers;

use App\Models\DrinkModel;

class Drink extends BaseController
{

  protected $drinkModel;
  public function __construct()
  {
    $this->drinkModel = new DrinkModel();
  }

  public function index()
  {
    $drink = $this->drinkModel->findAll();

    $data = [
      'title' => 'Orders | Drinks Store',
      'drink' => $drink
    ];


    return view('drink/index', $data);
  }
  public function addToCart()
    {
        // Ambil ID produk dari data POST
        $productId = $this->request->getPost('id');

        // Lakukan logika penambahan ke keranjang, misalnya simpan dalam sesi atau database
        // Di sini, kita akan menyimpan dalam sesi sebagai contoh
        $cart = session('cart') ?: [];

        // Periksa apakah produk sudah ada di keranjang
        if (array_key_exists($productId, $cart)) {
            // Jika sudah ada, tambahkan jumlahnya
            $cart[$productId]++;
        } else {
            // Jika belum, tambahkan produk ke keranjang dengan jumlah 1
            $cart[$productId] = 1;
        }

        // Simpan kembali keranjang ke dalam sesi
        session()->set('cart', $cart);

        // Kirim respons ke klien
        return $this->response->setJSON(['status' => 'success', 'message' => 'Product added to cart', 'productId' => $productId]);
    }

    public function checkout()
    {
        // Ambil data keranjang dari sesi
        $cart = session('cart') ?: [];

        $data = [
            'title' => 'Checkout | Drinks Store',
            'cartItems' => $cart
        ];

        return view('drink/checkout', $data);
    }

}