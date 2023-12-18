<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id', 'name', 'address', 'phone', 'subtotal', 'shipping_cost', 'total_price', 'delivery_id'
    ];

    public function store($data)
    {
        return $this->insert($data);
    }
}
