<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\DrinkModel;
use App\Models\OrderModel;
use stdClass;

class Checkout extends BaseController
{
    protected $drinkModel;
    protected $checkoutModel;
    protected $orderModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
        $this->drinkModel = new DrinkModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $checkout = [];
        $session = session();

        // Get cart items from the session
        $cart = $session->get('cart') ?? [];

        // Iterate through the cart items
        foreach ($cart as $productId) {
            $drinkData = $this->drinkModel->find($productId);

            if ($drinkData) {
                $product = new stdClass();
                $product->productid = $productId;
                $product->name = $drinkData['produk'];
                $product->image = $drinkData['gambar'];
                $product->price = $drinkData['harga'];

                // Append the product to the array
                $checkout[] = $product;
                // You can perfo rm any other operations with each product here
            }
        }
        $validation = \Config\Services::validation();
        $data = [
            'title' => 'Checkout',
            'validation' => $validation,
            'checkout' => $checkout
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
        $cart = session()->get('cart', []);

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

    public function saveOrder()
    {
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
        $this->orderModel->saveOrder($id, $name, $address, $phone, $subtotal, $shippingCost, $totalPrice);

        // Save order items
        // foreach ($productTableData as $product) {
        //     $this->orderModel->saveOrderItem($orderId, $product['product_id'], $product['quantity'], $product['price']);
        // }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order placed successfully!']);
    }
}
