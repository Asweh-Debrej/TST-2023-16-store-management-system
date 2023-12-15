<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'checkout';
    protected $primaryKey = 'id'; // Assuming 'id' is the primary key of the 'checkout' table

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
            // Add other fields as needed
        ];

        return $this->insert($data);
    }
}
