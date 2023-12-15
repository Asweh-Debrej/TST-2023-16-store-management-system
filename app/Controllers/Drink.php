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

  public function addToCheckout()
  {
    $productId = $this->request->getPost('id');
    $session = session();

    // Get the existing cart or create an empty array
    $cart = $session->get('cart', []);

    // Add the new product to the cart
    $cart[] = $productId;

    // Save the updated cart to the session
    $session->set('cart', $cart);

    // Set the status of the added item to checkout in the session
    $addedToCheckout = $session->get('added_to_checkout', []);

    // Ensure $addedToCheckout is an array
    if (!is_array($addedToCheckout)) {
      $addedToCheckout = [];
    }

    $addedToCheckout[$productId] = true;
    $session->set('added_to_checkout', $addedToCheckout);

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Product added to checkout',
      'productId' => $productId,
      'cart' => $cart,
    ]);
  }
}
