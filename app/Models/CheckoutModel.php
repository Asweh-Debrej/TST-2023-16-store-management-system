<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
  protected $table = 'checkout';
  protected $useTimestamps = true;
  protected $primaryKey = 'id'; // Assuming 'id' is the primary key of the 'checkout' table
}
