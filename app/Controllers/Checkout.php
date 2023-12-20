<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\DrinkModel;
use App\Models\OrderModel;
use App\Models\UserCartItemModel;
use App\Models\OrderItemModel;

class Checkout extends BaseController {
    protected $drinkModel;
    protected $checkoutModel;
    protected $orderModel;
    protected $cartModel;
    protected $orderItemModel;
    protected $client;

    public function __construct() {
        $this->checkoutModel = new CheckoutModel();
        $this->drinkModel = new DrinkModel();
        $this->orderModel = new OrderModel();
        $this->cartModel = new UserCartItemModel();
        $this->orderItemModel = new OrderItemModel();

        $options = [
            'http_errors' => false,
            'timeout' => 5,
        ];
        $this->client = \Config\Services::curlrequest($options);
    }

    public function index() {
        if (!auth()->loggedIn()) {
            return redirect()->to('login')->withInput()->with('error', lang('Auth.notLoggedIn'));
        }

        $userId = auth()->id();
        $user = auth()->getProvider()->findById($userId);
        $recipient = $user->username;

        $products = [];
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
            'products' => $products,
            'recipient' => $recipient,
        ];

        return view('pages/checkout', $data);
    }

    public function placeOrder() {
        if (!auth()->loggedIn()) {
            return redirect()->to('login')->withInput()->with('error', lang('Auth.notLoggedIn'));
        }

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

        $amounts = $this->request->getPost('amounts');

        if (empty($amounts)) {
            $errors[] = 'Please add some products to your cart first.';

            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $name = $this->request->getPost('name');
        $address = $this->request->getPost('address');
        $phone = $this->request->getPost('phone');

        $data = [
            'recipient' => $name,
            'sender' => getenv('api_delivery_origin'),
            'address' => $address,
            'phone_number' => $phone,
        ];

        $deliveryUrl = getenv('api_delivery_baseUrl') . '/order';
        try {
            $response = $this->client->post($deliveryUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . getenv('api_delivery_token'),
                ],
                'json' => $data,
            ]);

            if ($response->getStatusCode() === 401 || $response->getStatusCode() === 302) {
                if (delivery_login()) {
                    $response = $this->client->post($deliveryUrl, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . getenv('api_delivery_token'),
                        ],
                        'json' => $data,
                    ]);
                } else {
                    $errors[] = 'Failed to connect to delivery service. Please try again later.';
                }
            }

            if ($response->getStatusCode() !== 201) {
                $errors[] = $response->getBody();

                return redirect()->back()->withInput()->with('errors', $errors);
            }

            $deliveryData = json_decode($response->getBody(), true);
            $delivery_id = $deliveryData['data']['id'];
            $delivery_fee = $deliveryData['data']['total_amount'];
            $subtotal = 0;
            $productTableData = [];
            foreach ($amounts as $id => $amount) {
                if ($amount <= 0) {
                    continue;
                }

                if (!$this->drinkModel->find($id)) {
                    continue;
                }

                $subtotal += $this->drinkModel->find($id)['harga'] * $amount;
                array_push($productTableData, [
                    'product_id' => $id,
                    'price' => $this->drinkModel->find($id)['harga'],
                    'quantity' => $amount,
                ]);
            }

            if ($subtotal <= 0) {
                $errors[] = 'Please add some products to your cart first.';

                return redirect()->back()->withInput()->with('errors', $errors);
            }

            $totalPrice = $subtotal + $delivery_fee;

            // Retrieve data from the form
            $userId = auth()->id();

            // Save order information
            $this->orderModel->store([
                'user_id' => $userId,
                'name' => $name,
                'address' => $address,
                'phone' => $phone,
                'subtotal' => $subtotal,
                'shipping_cost' => $delivery_fee,
                'total_price' => $totalPrice,
                'delivery_id' => $delivery_id,
            ]);

            // Save order details
            $orderId = $this->orderModel->getInsertID();
            $this->orderItemModel->store($orderId, $productTableData);

            // Clear the cart
            $this->cartModel->deleteAllCartItems($userId);

            $successes = ['Order placed!'];

            return redirect()->to('status')->with('successes', $successes);
        } catch (\Exception $e) {
            $errors[] = 'Failed to connect to delivery service. Please try again later.';
        }
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
