<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\DrinkModel;
use App\Models\OrderModel;
use App\Models\UserCartItemModel;
use Config\Auth;

class Checkout extends BaseController
{
    protected $drinkModel;
    protected $checkoutModel;
    protected $orderModel;
    protected $cartModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
        $this->drinkModel = new DrinkModel();
        $this->orderModel = new OrderModel();
        $this->cartModel = new UserCartItemModel();
    }

    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login')->withInput()->with('error', lang('Auth.notLoggedIn'));
        }

        $products = [];
        $userId = auth()->id();
        $cartItems = $this->cartModel->getCartItems($userId);

        // Iterate through the cart items
        foreach ($cartItems as $item) {
            $drinkData = $this->drinkModel->getDrink($item['drink_id']);

            if ($drinkData) {
                array_push($products, [
                    'id' => $drinkData['id'],
                    'name' => $drinkData['produk'],
                    'price' => $drinkData['harga'],
                    'image' => $drinkData['gambar'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        $validation = \Config\Services::validation();
        $data = [
            'title' => 'Checkout',
            'validation' => $validation,
            'products' => $products
        ];

        return view('pages/checkout', $data);
    }

    public function initCheckoutSession()
    {
        $session = session();

        // Inisialisasi atau reset sesi checkout
        $session->set('cart', []);

        // Bisa juga tambahkan langkah-langkah inisialisasi lainnya jika diperlukan

        return true; // Untuk memberi tahu bahwa inisialisasi berhasil
    }

    public function updateQuantity()
    {
        $productId = $this->request->getPost('productId');
        $quantity = $this->request->getPost('quantity');

        // Retrieve the current cart from the session
        $cart = session()->get('cart');

        // Find the index of the product in the cart
        $index = array_search($productId, $cart);

        if ($index !== false) {
            // Update the quantity of the product in the cart
            // You may want to perform additional validation (e.g., check if the quantity is valid)
            $cart[$index]['quantity'] = $quantity;

            // Save the updated cart to the session
            session()->set('cart', $cart);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Quantity updated']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Product not found in the cart']);
        }
    }

    public function placeOrder()
    {
        // check auth
        // if (!auth()->check()) {
        //     return redirect()->to('/login');
        // }
        // Define validation rules with custom error messages
        $validationRules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'address' => 'required|min_length[5]|max_length[255]',
            'phone' => 'required|min_length[10]|max_length[15]',
        ];

        // Define custom error messages
        $validationMessages = [
            'name' => [
                'required' => 'The name field is required.',
                'min_length' => 'The name must be at least 3 characters.',
                'max_length' => 'The name cannot exceed 255 characters.',
            ],
            'address' => [
                'required' => 'The address field is required.',
                'min_length' => 'The address must be at least 5 characters.',
                'max_length' => 'The address cannot exceed 255 characters.',
            ],
            'phone' => [
                'required' => 'The phone field is required.',
                'min_length' => 'The phone must be at least 10 characters.',
                'max_length' => 'The phone cannot exceed 15 characters.',
            ],
        ];

        $errors = [];

        // Run validation with custom error messages
        if (!$this->validate($validationRules, $validationMessages)) {
            // Retrieve errors from the validator
            $errors = $this->validator->getErrors();

            // redirect back withinput and error
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Check if there is at least one product ordered
        $productTableData = $this->request->getPost('productTable');
        if (empty($productTableData)) {
            $errors[] = 'At least one product is required for the order.';
            // redirect back withinput and error
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Retrieve data from the form
        $id = 1;
        $name = $this->request->getPost('name');
        $address = $this->request->getPost('address');
        $phone = $this->request->getPost('phone');
        $subtotal = $this->request->getPost('subtotal');
        $shippingCost = $this->request->getPost('shippingcost');
        $totalPrice = $this->request->getPost('totalPrice');

        // Save order information
        $this->orderModel->store($id, $name, $address, $phone, $subtotal, $shippingCost, $totalPrice);

        // Save order items
        // foreach ($productTableData as $product) {
        //     $this->orderModel->saveOrderItem($orderId, $product['product_id'], $product['quantity'], $product['price']);
        // }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order placed successfully!']);
    }

    public function storeCart() {

        if (!auth()->loggedIn()) {
            return redirect()->to('login')->withInput()->with('error', lang('Auth.notLoggedIn'));
        }

        $userId = auth()->id();
        $amounts = $this->request->getPost('amountsInput');

        $cartModel = new UserCartItemModel();
        $cartModel->deleteAllCartItems($userId);

        foreach ($amounts as $id => $amount) {
            if ($amount <= 0) {
                continue;
            }

            if (!$this->drinkModel->find($id)) {
                continue;
            }

            $cartModel->insert([
                'user_id' => $userId,
                'drink_id' => $id,
                'quantity' => $amount,
            ]);
        }

        $successes = ['Cart updated!'];

        return redirect()->back()->with('successes', $successes);
    }
}
