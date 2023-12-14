<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Drink::index');
$routes->post('/cart/add', 'Drink::addToCart');
$routes->get('/cart', 'Pages::index');

