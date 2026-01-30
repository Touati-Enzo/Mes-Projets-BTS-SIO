<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Routes d'authentification (publiques)
$routes->group('auth', function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::attemptRegister');
    $routes->get('logout', 'AuthController::logout');
});

// Alias pour accès facile
$routes->get('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

// Routes protégées (nécessitent authentification)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('dashboard', 'DashboardController::index');

    // Routes des réservations
    $routes->get('reservations', 'ReservationController::index');
    $routes->get('reservations/create', 'ReservationController::create');
    $routes->post('reservations/store', 'ReservationController::store');
    $routes->get('reservations/detail/(:num)', 'ReservationController::detail/$1');
    $routes->get('reservations/cancel/(:num)', 'ReservationController::cancel/$1');

    // Routes des chambres
    $routes->get('chambres', 'ChambreController::index');
    $routes->get('chambres/detail/(:num)', 'ChambreController::detail/$1');
    $routes->get('chambres/create', 'ChambreController::create');
    $routes->post('chambres/store', 'ChambreController::store');
    $routes->get('chambres/edit/(:num)', 'ChambreController::edit/$1');
    $routes->post('chambres/update/(:num)', 'ChambreController::update/$1');
    $routes->get('chambres/delete/(:num)', 'ChambreController::delete/$1');

    // Routes du profil
    $routes->get('profile', 'ProfileController::index');
    $routes->get('settings', 'ProfileController::settings');
});

/**
 * Additional Routing
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
