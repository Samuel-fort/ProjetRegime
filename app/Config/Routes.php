<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Inscription en 2 étapes
$routes->get('/register',        'AuthController::register');
$routes->post('/register/step1', 'AuthController::registerStep1Post');
$routes->get('/register/step2',  'AuthController::registerStep2');
$routes->post('/register/step2', 'AuthController::registerStep2Post');

// Login/logout
$routes->get('/',  'AuthController::login');
$routes->post('/login', 'AuthController::loginPost');
$routes->get('/logout', 'AuthController::logout');