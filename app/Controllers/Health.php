<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Health extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'message' => 'OK',
        ]);
    }
}
