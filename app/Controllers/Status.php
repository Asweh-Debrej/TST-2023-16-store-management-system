<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Status extends BaseController
{
    protected $orderModel;
    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }
    public function index()
    {
        $orders = $this->orderModel->findAll();

        $data = [
            'title' => 'Your Orders',
            'order' => $orders
        ];


        return view('pages/status', $data);
    }
}
