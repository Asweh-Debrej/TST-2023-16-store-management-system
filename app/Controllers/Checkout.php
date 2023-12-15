<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\DrinkModel;
use stdClass;

class Checkout extends BaseController
{
    protected $drinkModel;
    protected $checkoutModel;
    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
        $this->drinkModel = new DrinkModel();
    }

    public function index()
    {
        $checkout = [];
        //user id = 1, ini baru dummy doang ya rana
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

    public function createOrder()
    {
    }
}
