<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $useTimestamps = true;
    
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
            'total_price' => $totalPrice,
        ];

        return $this->insert($data);
    }
}
