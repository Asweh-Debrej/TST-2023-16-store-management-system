<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id', 'name', 'address', 'phone', 'subtotal', 'shipping_cost', 'total_price'
    ];

    public function saveOrder($userId, $name, $address, $phone, $subtotal, $shippingCost, $totalPrice)
    {
        $data = [
            'user_id' => $userId,
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total_price' => $totalPrice,
        ];

        return $this->insert($data);
    }
}
