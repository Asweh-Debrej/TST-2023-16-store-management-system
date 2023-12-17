<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/drink', 'Drink::index', ['as' => 'drink']);
$routes->addRedirect('/', 'drink');
$routes->get('/checkout', 'Checkout::index', ['as' => 'checkout']);
$routes->post('/checkout/saveOrder', 'Checkout::saveOrder', ['as' => 'saveOrder']);
$routes->get('/status', 'Status::index', ['as' => 'status']);
$routes->post('/drink/addToCheckout', 'Drink::addToCheckout', ['as' => 'addToCheckout']);



service('auth')->routes($routes);
