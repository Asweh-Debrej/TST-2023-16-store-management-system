<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Drink::index');
$routes->get('/checkout', 'Checkout::index');
// // $routes->get('/orderlist', 'OrderList::index');


// service('auth')->routes($routes);
