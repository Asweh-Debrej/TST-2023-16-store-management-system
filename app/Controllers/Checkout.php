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
        $checkoutData = $this->checkoutModel->find(1, 'userid');

        if ($checkoutData) {
            // Decode the JSON-encoded products array
            $productsArray = json_decode($checkoutData['products'], true);

            // Iterate through the products array
            foreach ($productsArray as $productId) {
                $drinkData = $this->drinkModel->find($productId);
                $product = new stdClass();
                $product->productid = $productId;
                $product->name = $drinkData['produk'];
                $product->image = $drinkData['gambar'];
                $product->price = $drinkData['harga'];

                // Append the product to the arra
                $checkout[] = $product;
                // You can perform any other operations with each product here
            }
        } else {
            // Data not found
            echo "Checkout not found for user ID";
        }

        $data = [
            'title' => 'Checkout',
            'checkout' => $checkout
        ];
        return view('pages/checkout', $data);
    }

    public function saveOrder()
    {
        // Define validation rules
        $validationRules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'address' => 'required|min_length[5]|max_length[255]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'subtotal' => 'required|numeric',
            'shippingcost' => 'required|numeric',
            'totalPrice' => 'required|numeric',
        ];

        // Run validation
        if (!$this->validate($validationRules)) {
            // If validation fails, redirect back with errors
            return redirect()->to('/checkout');
        }

        // Check if there is at least one product ordered
        // Assuming that the productTable is an array and should have at least one element
        $productTableData = $this->request->getPost('productTable');
        if (empty($productTableData)) {
            return redirect()->to('/checkout')->withInput();
        }


        // Retrieve data from the form
        $userId = 1;
        // $userId = session()->get('user_id');;
        $name = $this->request->getPost('name');
        $address = $this->request->getPost('address');
        $phone = $this->request->getPost('phone');
        $subtotal = $this->request->getPost('subtotal');
        $shippingCost = $this->request->getPost('shippingcost');
        $totalPrice = $this->request->getPost('totalPrice');
        // $productTableData = $this->request->getPost('productTable');

        // Save order information
        $this->orderModel->saveOrder($userId, $name, $address, $phone, $subtotal, $shippingCost, $totalPrice);

        // Save order items
        // foreach ($productTableData as $product) {
        //     $this->orderModel->saveOrderItem($orderId, $product['product_id'], $product['quantity'], $product['price']);
        // }

        // Optionally, you might want to redirect the user to a thank you page
        return redirect()->to('/thankyou');
    }
}
