<?php

namespace App\Controllers;

use App\Models\DrinkModel;
use App\Models\UserCartItemModel;

class Drink extends BaseController
{
  protected $drinkModel;

  public function __construct()
  {
    $this->drinkModel = new DrinkModel();
  }

  public function index()
  {
    // Panggil fungsi inisialisasi checkout session
    $this->initCheckoutSession();

    $drink = $this->drinkModel->findAll();

    // Dapatkan status add to checkout dari sesi
    $addedToCheckout = session()->get('added_to_checkout', []);

    $data = [
      'title' => 'Orders | Drinks Store',
      'drink' => $drink,
      'addedToCheckout' => $addedToCheckout,
    ];

    return view('drink/index', $data);
  }

  protected function initCheckoutSession()
  {
    $session = session();

    // Inisialisasi atau reset sesi checkout
    $session->set('cart', []);

    // Bisa juga tambahkan langkah-langkah inisialisasi lainnya jika diperlukan

    return true; // Untuk memberi tahu bahwa inisialisasi berhasil
  }

  public function addToCart()
  {
    $productId = $this->request->getJsonVar('productId');

    // cek apakah user sudah login
    if (!auth()->loggedIn()) {
      return redirect()->to('login')->withInput()->with('error', lang('Auth.notLoggedIn'));
    }

    $userId = auth()->id();

    // Cek apakah produk sudah ada di cart
    $cartModel = new UserCartItemModel();
    $cartItem = $cartModel->getCartItem($userId, $productId);

    if ($cartItem) {
      // Jika produk sudah ada di cart, maka tambahkan jumlahnya
      $cartModel->update($cartItem['id'], ['quantity' => $cartItem['quantity'] + 1]);
    } else {
      // Jika belum ada, maka tambahkan produknya
      $cartModel->insert([
        'user_id' => $userId,
        'drink_id' => $productId,
        'quantity' => 1,
      ]);
    }

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Product added to checkout',
      'productId' => $productId,
    ]);
  }

  // // kurangi 1
  // public function removeFromCart()
  // {
  //   $productId = $this->request->getJsonVar('productId');

  //   // cek apakah user sudah login
  //   if (!auth()->loggedIn()) {
  //     return redirect()->to('login')->withInput()->with('error', lang('Auth.notLoggedIn'));
  //   }

  //   $userId = auth()->id();

  //   // Cek apakah produk sudah ada di cart
  //   $cartModel = new UserCartItemModel();
  //   $cartItem = $cartModel->getCartItem($userId, $productId);

  //   if ($cartItem) {
  //     // Jika produk sudah ada di cart, maka kurangi jumlahnya
  //     $cartModel->update($cartItem['id'], ['quantity' => $cartItem['quantity'] - 1]);
  //   } else {
  //     // Jika belum ada, maka tambahkan produknya
  //     $cartModel->insert([
  //       'user_id' => $userId,
  //       'drink_id' => $productId,
  //       'quantity' => 1,
  //     ]);
  //   }

  //   return $this->response->setJSON([
  //     'status' => 'success',
  //     'message' => 'Product added to checkout',
  //     'productId' => $productId,
  //   ]);
  // }
}
