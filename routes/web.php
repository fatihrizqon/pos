<?php

use Illuminate\Support\Facades\Route;
 
$router->get('/', 'AppController@index');

$router->group(['prefix' => 'api'], function () use ($router) {
    
    $router->post('/auth/register', 'AuthController@register');
    $router->post('/auth/login', 'AuthController@login');
    $router->get('/auth/logout', 'AuthController@logout');

    // Protected by JWT
    $router->group(['middleware' => 'jwt.auth'], function () use($router){
        $router->get('/profile', 'AuthController@profile');

        $router->get('/categories', 'ProductCategoryController@index');
        $router->post('/category/create', 'ProductCategoryController@create');
        $router->post('/category/import', 'ProductCategoryController@import');
        $router->get('/category/view/{id}', 'ProductCategoryController@view');
        $router->put('/category/update/{id}', 'ProductCategoryController@update');
        $router->delete('/category/delete/{id}', 'ProductCategoryController@delete');
    
        $router->get('/products', 'ProductController@index');
        $router->get('/allproducts', 'ProductController@allproducts');
        $router->post('/product/create', 'ProductController@create');
        $router->post('/product/import', 'ProductController@import');
        $router->get('/product/view/{id}', 'ProductController@view');
        $router->put('/product/update/{id}', 'ProductController@update');
        $router->delete('/product/delete/{id}', 'ProductController@delete');

        $router->get('/orders', 'OrderController@index');
        $router->post('/order/create', 'OrderController@create');
        $router->get('/order/view/{id}', 'OrderController@view');
        $router->put('/order/update/{id}', 'OrderController@update');
        $router->delete('/order/delete/{id}', 'OrderController@delete');
        
        $router->get('/transactions', 'TransactionController@index');
        $router->get('/transactions/data', 'TransactionController@transactions');
        $router->post('/transaction/create', 'TransactionController@create');
        $router->get('/transaction/view/{id}', 'TransactionController@view');
        $router->put('/transaction/update/{id}', 'TransactionController@update');
        $router->delete('/transaction/delete/{id}', 'TransactionController@delete');
        
        $router->get('/supplies', 'SupplyController@index');
        $router->post('/supply/create', 'SupplyController@create');
        $router->get('/supply/view/{id}', 'SupplyController@view');
        $router->put('/supply/update/{id}', 'SupplyController@update');
        $router->delete('/supply/delete/{id}', 'SupplyController@delete');

        $router->get('/suppliers', 'SupplierController@index');
        $router->post('/supplier/create', 'SupplierController@create');
        $router->post('/supplier/import', 'SupplierController@import');
        $router->get('/supplier/view/{id}', 'SupplierController@view');
        $router->put('/supplier/update/{id}', 'SupplierController@update');
        $router->delete('/supplier/delete/{id}', 'SupplierController@delete');

        $router->get('/cashflows', 'CashflowController@index');
        $router->post('/cashflow/create', 'CashflowController@create');
        $router->get('/cashflow/view/{id}', 'CashflowController@view');
        $router->put('/cashflow/update/{id}', 'CashflowController@update');
        $router->delete('/cashflow/delete/{id}', 'CashflowController@delete');

        $router->get('/users', 'UserController@index'); 
        $router->get('/user/view/{id}', 'UserController@view');
        $router->put('/user/update/{id}', 'UserController@update');
        $router->delete('/user/delete/{id}', 'UserController@delete');
    });

});
