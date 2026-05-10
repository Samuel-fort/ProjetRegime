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
$routes->get('/',       'AuthController::login');
$routes->get('/login',  'AuthController::login');
$routes->post('/login', 'AuthController::loginPost');
$routes->get('/logout', 'AuthController::logout');

// Routes utilisateur
$routes->get('/user/dashboard', 'Home::index');

// Routes admin
$routes->get('admin/dashboard',                'AdminController::dashboard');
$routes->get('admin/regimes',                  'AdminController::regimes');
$routes->get('admin/regimes/create',           'AdminController::regimeCreate');
$routes->post('admin/regimes/store',           'AdminController::regimeStore');
$routes->get('admin/regimes/edit/(:num)',      'AdminController::regimeEdit/$1');
$routes->post('admin/regimes/update/(:num)',   'AdminController::regimeUpdate/$1');
$routes->get('admin/regimes/delete/(:num)',    'AdminController::regimeDelete/$1');
$routes->get('admin/activites',                'AdminController::activites');
$routes->get('admin/activites/create',         'AdminController::activiteCreate');
$routes->post('admin/activites/store',         'AdminController::activiteStore');
$routes->get('admin/activites/edit/(:num)',    'AdminController::activiteEdit/$1');
$routes->post('admin/activites/update/(:num)', 'AdminController::activiteUpdate/$1');
$routes->get('admin/activites/delete/(:num)',  'AdminController::activiteDelete/$1');
$routes->get('admin/codes',                    'AdminController::codes');
$routes->get('admin/codes/create',             'AdminController::codeCreate');
$routes->post('admin/codes/store',             'AdminController::codeStore');
$routes->get('admin/codes/delete/(:num)',      'AdminController::codeDelete/$1');


// Routes porte feuille
$routes->get('/wallet', 'WalletController::index');
$routes->get('/wallet/test', 'WalletController::test');
$routes->get('/wallet/solde', 'WalletController::solde');
$routes->post('/wallet/valider_code', 'WalletController::validerCode');