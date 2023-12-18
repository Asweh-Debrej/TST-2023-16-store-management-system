<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/drink', 'Drink::index', ['as' => 'drink']);
$routes->addRedirect('/', 'drink');
$routes->get('/checkout', 'Checkout::index', ['as' => 'checkout']);
$routes->post('/checkout/place-order', 'Checkout::placeOrder', ['as' => 'placeOrder']);
$routes->get('/status', 'Status::index', ['as' => 'status']);
$routes->post('/drink/addToCheckout', 'Drink::addToCheckout', ['as' => 'addToCheckout']);
$routes->post('/checkout/save', 'Checkout::storeCart', ['as' => 'saveCart']);

service('auth')->routes($routes);
