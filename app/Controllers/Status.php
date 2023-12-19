<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Status extends BaseController
{
    protected $client;
    protected $orderModel;
    public function __construct()
    {
        $this->orderModel = new OrderModel();

        $options = [
            'http_errors' => false,
            'timeout' => 5,
        ];
        $this->client = \Config\Services::curlrequest($options);
        $this->client->setHeader('Accept', 'application/json');
    }
    public function index()
    {
        $orders = $this->orderModel->findAll();

        foreach ($orders as $key => $o) {
            $response = $this->client->get(getenv('api_delivery_baseUrl') .  '/order/' . $o['delivery_id'], [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . getenv('api_delivery_token'),
                ],
            ]);

            if ($response->getStatusCode() === 401) {
                if (delivery_login()) {
                    $response = $this->client->get(getenv('api_delivery_baseUrl') .  '/order/' . $o['delivery_id'], [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . getenv('api_delivery_token'),
                        ],
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
    }

    public function updateOrder($id)
    {
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', 'http://localhost:8081/api/assignment/' . $id);
        $body = $response->getBody();

        // Assuming the API response contains the status information
        $responseData = json_decode($body, true);

        $data['status'] = $responseData['status'];
        $data['estimated_arrival'] = $responseData['estimated_arrival'];


        // return $this->response->setJSON($data);

        $res = $this->orderModel->update($id, [
            'status' => $data['status'],
            'estimated_arrival' => $data['estimated_arrival'],
        ]);

        return $this->response->setJSON($res);
    }
}
