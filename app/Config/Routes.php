<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Drink::index');
$routes->get('/checkout', 'Checkout::index');
$routes->post('/checkout/saveOrder', 'Checkout::saveOrder');
$routes->get('/status', 'Status::index');


// service('auth')->routes($routes);
