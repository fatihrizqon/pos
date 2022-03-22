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
 
});