<?php

namespace App\Controllers;

use App\Models\DrinkModel;

class Drink extends BaseController
{

  protected $drinkModel;
  public function __construct()
  {
    $this->drinkModel = new DrinkModel();
  }

  public function index()
  {
    $drink = $this->drinkModel->findAll();

    $data = [
      'title' => 'Orders | Drinks Store',
      'drink' => $drink
    ];


    return view('drink/index', $data);
  }
}