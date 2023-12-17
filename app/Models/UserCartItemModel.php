<?php

namespace App\Models;

use CodeIgniter\Model;

class UserCartItemModel extends Model
{
    protected $table            = 'user_cart_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getCartItems(int $userId)
    {
        $cartModel = new UserCartItemModel();

        return $cartModel->where('user_id', $userId)->findAll();
    }

    public function getCartItem(int $userId, int $drinkId)
    {
        $cartModel = new UserCartItemModel();

        return $cartModel->where('user_id', $userId)->where('drink_id', $drinkId)->first();
    }
}
