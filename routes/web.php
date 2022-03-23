<?php

$router->get('/', 'AppController@index');

$router->group(['prefix' => 'api'], function() use ($router){
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
    
    $router->get('/supplies', 'SupplyController@index');
    $router->post('/supply/create', 'SupplyController@create');
    $router->get('/supply/view/{id}', 'SupplyController@view');
    // $router->put('/supply/update/{id}', 'SupplyController@update');
    $router->delete('/supply/delete/{id}', 'SupplyController@delete');
 
});