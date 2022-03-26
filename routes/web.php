<?php

use Illuminate\Support\Facades\Route;

$router->get('/', 'AppController@index');

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/categories', 'ProductCategoryController@index');
    $router->post('/category/create', 'ProductCategoryController@create');
    $router->get('/category/view/{id}', 'ProductCategoryController@view');
    $router->put('/category/update/{id}', 'ProductCategoryController@update');
    $router->delete('/category/delete/{id}', 'ProductCategoryController@delete');

    $router->get('/products', 'ProductController@index');
    $router->post('/product/create', 'ProductController@create');
    $router->get('/product/view/{id}', 'ProductController@view');
    $router->put('/product/update/{id}', 'ProductController@update');
    $router->delete('/product/delete/{id}', 'ProductController@delete');

    $router->get('/stocks', 'StockController@index');
    $router->post('/stock/create', 'StockController@create');
    $router->get('/stock/view/{id}', 'StockController@view');
    $router->put('/stock/update/{id}', 'StockController@update');
    $router->delete('/stock/delete/{id}', 'StockController@delete');

    $router->get('/orders', 'OrderController@index');
    $router->post('/order/create', 'OrderController@create');
    $router->get('/order/view/{id}', 'OrderController@view');
    $router->put('/order/update/{id}', 'OrderController@update');
    $router->delete('/order/delete/{id}', 'OrderController@delete');
    
    $router->get('/transactions', 'TransactionController@index');
    $router->post('/transaction/create', 'TransactionController@create');
    $router->get('/transaction/view/{id}', 'TransactionController@view');
    $router->put('/transaction/update/{id}', 'TransactionController@update');
    $router->delete('/transaction/delete/{id}', 'TransactionController@delete');
    
    /* Purchases */
    $router->get('/purchases', 'SupplyController@index');
    $router->post('/purchase/create', 'SupplyController@create');
    $router->get('/purchase/view/{id}', 'SupplyController@view');
    $router->put('/purchase/update/{id}', 'SupplyController@update');
    $router->delete('/purchase/delete/{id}', 'SupplyController@delete');

});

/*
    -> Setiap Transaction & Supply Baru, masuk ke notifikasi email manajer.
    -> Ketika ada Stock Product 0, masuk ke notifikasi email manajer.
    *Bisa mute.
*/

/*
    Algoritma penjualan:
    1. Create a New Transaction (ID).
    2. Create a New Transaction, 1 Transaction many Orders.
    3. 
    ------------------------------------------------------------------
    1. Klik New Order.
    2. Insert Product & Quantity => New Order
    3. Klik Check Out => Mengumpulkan semua order jadi 1, menghitung total_price
    4. Klik Pay => New Transaction
*/

/*

*/