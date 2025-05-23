<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/Profil', 'Login::Profil');
$routes->post('/Login/Authenticate', 'Login::authenticate');
$routes->get('/Invite','Login::invite');
$routes->get('/Create','Login::create');
$routes->post('Login/Account' , 'Login::account');
$routes->get('/Logout','Login::Logout');




