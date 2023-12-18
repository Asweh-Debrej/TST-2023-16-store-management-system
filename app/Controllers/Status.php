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
