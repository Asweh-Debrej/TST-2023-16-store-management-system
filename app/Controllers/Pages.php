<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Orders | Drinks Store'
        ];

        echo view('pages/orders', $data);
    }
}
