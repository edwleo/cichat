<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Desplegar la vista
$routes->get('websocket', 'WebSocketController::index');
$routes->get('/averias', 'AveriaController::index');
$routes->get('/averias/registrar', 'AveriaController::registrar');

//Procesos
$routes->post('public/api/averias/registrar', 'AveriaController::agregarRegistro');
$routes->get('public/api/averias/listar', 'AveriaController::listarAverias');