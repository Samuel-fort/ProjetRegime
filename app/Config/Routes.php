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

// Routes utilisateur protégées
$routes->group('', ['filter' => 'userAuth'], static function ($routes) {
	$routes->get('dashboard', 'Dashboard::index');
	$routes->get('user/dashboard', 'Dashboard::index');
	$routes->match(['get', 'post'], 'profil/modifier', 'Profil::modifier');
	$routes->get('wallet', 'WalletController::index');
	$routes->get('wallet/test', 'WalletController::test');
	$routes->get('wallet/solde', 'WalletController::solde');
	$routes->post('wallet/valider_code', 'WalletController::validerCode');

	// Objectifs utilisateur
	$routes->match(['get','post'], 'objectif/choisir', 'Objectif::choisir');
	$routes->get('objectif/suggestions', 'Objectif::suggestions');
	$routes->get('objectif/suggestions/pdf', 'Objectif::exportSuggestionsPdf');
});

// Routes admin protégées
$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
	$routes->get('dashboard',                'AdminController::dashboard');
	$routes->get('regimes',                  'AdminController::regimes');
	$routes->get('regimes/create',           'AdminController::regimeCreate');
	$routes->post('regimes/store',           'AdminController::regimeStore');
	$routes->get('regimes/edit/(:num)',      'AdminController::regimeEdit/$1');
	$routes->post('regimes/update/(:num)',   'AdminController::regimeUpdate/$1');
	$routes->get('regimes/delete/(:num)',    'AdminController::regimeDelete/$1');
	$routes->get('activites',                'AdminController::activites');
	$routes->get('activites/create',         'AdminController::activiteCreate');
	$routes->post('activites/store',         'AdminController::activiteStore');
	$routes->get('activites/edit/(:num)',    'AdminController::activiteEdit/$1');
	$routes->post('activites/update/(:num)', 'AdminController::activiteUpdate/$1');
	$routes->get('activites/delete/(:num)',  'AdminController::activiteDelete/$1');
	$routes->get('codes',                    'AdminController::codes');
	$routes->get('codes/create',             'AdminController::codeCreate');
	$routes->post('codes/store',             'AdminController::codeStore');
	$routes->get('codes/delete/(:num)',      'AdminController::codeDelete/$1');
});
