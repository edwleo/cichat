<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Desplegar la vista
$routes->get('websocket', 'WebSocketController::index');