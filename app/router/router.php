<?php

$uri = $_SERVER['REQUEST_URI'];

function pageNotFound($msg = 'Page introuvable') {
    header('HTTP/1.1 404 Not Found', true, 404);
    echo $msg;
}

$router = new AltoRouter();

define('VIEW_PATH', realpath(__DIR__ . '/../'));

$router->map('GET', '/produit', function() {
    echo 'dddddd';
});

$router->map('GET', '/produit/[i:id]', function($productId) {
    // echo 'je suis ' . $lol;
    require VIEW_PATH . '/productDetails.php';
}, 'product.show');

$router->map('GET | POST', '/login', function() {
    require VIEW_PATH . '/auth/login.php';
}, 'login');

$router->map('GET | POST', '/register', function() {
    require VIEW_PATH . '/auth/register.php';
}, 'register');

$router->map('GET', '/logout', function() {
    require VIEW_PATH . '/auth/logout.php';
}, 'logout');


$router->map('GET', '/confirm', function() {
    require VIEW_PATH . '/auth/confirm.php';
}, 'confirm');

$router->map('GET | POST', '/forget', function() {
    require VIEW_PATH . '/auth/forget.php';
}, 'forget');

$router->map('GET | POST', '/booking', function() {
    require VIEW_PATH . '/booking/booking.php';
}, 'booking');

$router->map('GET | POST', '/authbooking', function() {
    require VIEW_PATH . '/auth/allbooking.php';
}, 'authbooking');

// $router->map('GET | POST', '/reservations/[i:id]', function() {
//     require VIEW_PATH . '/booking/reservations.php';
// }, 'reservations');
/**
 * ABOUT 
 */

$router->map('GET | POST', '/about', function() {
    require VIEW_PATH . '/menu/about.php';
}, 'about');


$router->map('GET | POST', '/reset', function() {
    require VIEW_PATH . '/auth/reset.php';
}, 'reset');

$router->map('GET | POST', '/account', function() {
    require VIEW_PATH . '/auth/account.php';
}, 'account');

$router->map('GET | POST', '/addProduct', function() {
    require VIEW_PATH . '/auth/addProduct.php';
}, 'addProduct');

$router->map('GET | POST', '/addCategory', function() {
    require VIEW_PATH . '/auth/addCategory.php';
}, 'addCategory');

$router->map('GET | POST', '/addCoupon', function() {
    require VIEW_PATH . '/auth/addCoupon.php';
}, 'addCoupon');

$router->map('GET | POST', '/allUsers', function() {
    require VIEW_PATH . '/auth/allUsers.php';
}, 'allUsers');


$router->map('GET | POST', '/delete', function() {
    require VIEW_PATH . '/auth/delete.php';
}, 'delete');

$router->map('GET', '/admin', function() {
    require VIEW_PATH . '/auth/admin.php';
}, 'admin');

$router->map('GET', '/admin/product/[i:id]', function($productId) {
    require VIEW_PATH . '/auth/edit.php';
}, 'admin.product.edit');


$router->map('GET | POST', '/admin/edit/[i:id]', function($productId) {
    require VIEW_PATH . '/auth/edit.php';
}, 'adminedit');

$router->map('GET | POST', '/admin/delete/[i:id]', function($productId) {
    require VIEW_PATH . '/auth/delete.php';
}, 'admindelete');

$router->map('GET | POST', '/admin/deleteCategory/[i:id]', function($productId) {
    require VIEW_PATH . '/auth/deleteCategorie.php';
}, 'deleteCategory');

$router->map('GET | POST', '/admin/deleteBooking/[i:id]', function($productId) {
    require VIEW_PATH . '/auth/deleteBooking.php';
}, 'deleteBooking');

$router->map('GET', '/', function() {
    require VIEW_PATH . '/products.php';
}, 'home');

$match = $router->match();
if ($match === false) {
    $match = [
        'target' => 'pageNotFound',
        'name' => '',
        'params' => []
    ];
}

// var_dump($router->generate('produit.show', ['id' => 1]));
call_user_func_array($match['target'], $match['params']);

// Routes admin crud (version laravel: https://laravel.com/docs/5.7/controllers#resource-controllers)

// Ressource : produits (products)
/**
 * [GET] /admin/products => /Liste les produits
 * [GET] /admin/products/new => Formulaire d'ajour d'un produit
 * [POST] /admin/products => Traitement du formulaire d'ajout (insert sql)
 * 
 * [GET] /admin/products/{id} => Formulaire d'édition d'un produit (id en paramètre)
 * [POST] /admin/products/{id} => Traitement du formulaire d'édition du produit (update sql)
 * [DELETE] /admin/products/{id} => Suppression d'un produit (delete sql)
 */
