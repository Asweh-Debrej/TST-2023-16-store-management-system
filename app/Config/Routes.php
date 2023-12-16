<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Drink::index');
$routes->get('/status', 'Status::index');
$routes->get('/checkout', 'Checkout::index');
$routes->post('/drink/addToCheckout', 'Drink::addToCheckout');
$routes->post('/checkout/save', 'Checkout::saveOrder');



// service('auth')->routes($routes);
