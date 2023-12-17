<?php

namespace App\Models;

use CodeIgniter\Model;

class DrinkModel extends Model
{
  protected $table = 'drinks';
  protected $useTimestamps = true;
  protected $allowedFields = ['produk', 'harga', 'gambar'];

  public function getDrink($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }

    return $this->where(['id' => $id])->first();
  }

  public function search($keyword)
  {
    return $this->table('drinks')->like('produk', $keyword)->orLike('harga', $keyword);
  }
}
