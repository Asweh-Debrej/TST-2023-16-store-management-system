<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Drink::index');
$routes->get('/checkout', 'Checkout::index');
$routes->get('/status', 'Status::index');


// service('auth')->routes($routes);
