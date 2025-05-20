<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// Public routes
$routes->get('/', 'LoginController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::processLogin');
$routes->get('/logout', 'LoginController::logout');

// Protected routes
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/index', 'HomeController::index');
    $routes->get('/anggota', 'AnggotaController::index');
    $routes->post('/anggota/tambah', 'AnggotaController::tambah');
    $routes->post('/anggota/edit/(:alphanum)', 'AnggotaController::edit/$1');
    $routes->post('/anggota/hapus/(:alphanum)', 'AnggotaController::hapus/$1');
    $routes->get('/buku', 'BukuController::buku');
    $routes->post('/buku/tambah', 'BukuController::tambah');
    $routes->post('/buku/edit/(:alphanum)', 'BukuController::edit/$1');
    $routes->post('/buku/hapus/(:alphanum)', 'BukuController::hapus/$1');
    $routes->get('/peminjaman', 'PeminjamanController::peminjaman');
    $routes->post('/peminjaman/tambah', 'PeminjamanController::tambah');
    $routes->post('/peminjaman/edit/(:alphanum)', 'PeminjamanController::edit/$1');
    $routes->post('/peminjaman/hapus/(:alphanum)', 'PeminjamanController::hapus/$1');
});
