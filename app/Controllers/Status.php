<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Status extends BaseController {
    protected $client;
    protected $orderModel;
    public function __construct() {
        $this->orderModel = new OrderModel();

        $options = [
            'http_errors' => false,
            'timeout' => 5,
        ];
        $this->client = \Config\Services::curlrequest($options);
        $this->client->setHeader('Accept', 'application/json');
    }
    public function index() {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('errors', ['You must login first']);
        }

        // mencari order berdasarkan user_id
        $user_id = auth()->id();
        $orders = $this->orderModel->where('user_id', $user_id)->findAll();

        try {
            foreach ($orders as $key => $o) {
                $response = $this->client->get(getenv('api_delivery_baseUrl') .  '/order/' . $o['delivery_id'], [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . getenv('api_delivery_token'),
                    ],
                    'debug' => true,
                    'verify' => false,
                    'http_errors' => false,
                ]);

                if ($response->getStatusCode() === 401 || $response->getStatusCode() === 302) {
                    if (delivery_login()) {
                        $response = $this->client->get(getenv('api_delivery_baseUrl') .  '/order/' . $o['delivery_id'], [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                                'Authorization' => 'Bearer ' . getenv('api_delivery_token'),
                            ],
                            'debug' => true,
                            'verify' => false,
                            'http_errors' => false,
                        ]);
                    } else {
                        return redirect()->back()->with('errors', ["we're having trouble connecting to the delivery service"]);
                    }
                }

                if ($response->getStatusCode() === 404 || $response->getStatusCode() === 403) {
                    continue;
                } else if ($response->getStatusCode() >= 300) {
                    return redirect()->back()->with('errors', ["unknown error occured"]);
                }

                $body = $response->getBody();
                $responseData = json_decode($body, true);

                $orders[$key]['status'] = $responseData['data']['status'];
                $orders[$key]['estimated_arrival'] = $responseData['data']['estimated_arrival'];
            }

            $data = [
                'title' => 'Your Orders',
                'order' => $orders
            ];

            return view('pages/status', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', ["we're having trouble connecting to the delivery service"]);
        }
    }
}
