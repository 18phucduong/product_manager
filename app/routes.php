<?php
    $routes['home.index'] = setRoute('get', '/home', 'HomeController@index'); 
    // Authentication
    $routes['auth.loginPage'] = setRoute('get', '/login', 'AuthController@login_view');
    $routes['auth.login'] = setRoute('post', '/login', 'AuthController@login');
    $routes['auth.logout'] = setRoute('get', '/logout', 'AuthController@logout');
    // Tags
    $routes['tag.index'] = setRoute('get', '/tag', 'TagController@create');
    $routes['tag.new'] = setRoute('get', '/tag/new', 'TagController@create');
    $routes['tag.store'] = setRoute('post', '/tag/store', 'TagController@store');
    $routes['tag.eidt'] = setRoute('get', '/tag/edit/{id}', 'TagController@edit');
    $routes['tag.update'] = setRoute('post', '/tag/update/{id}', 'TagController@update');
    $routes['tag.delete'] = setRoute('delete', '/tag/delete{id}', 'TagController@delete');
    // Product
    $routes['product.index'] = setRoute('get', '/product', 'ProductController@index');
    $routes['product.new'] = setRoute('get', '/product/new', 'ProductController@create');
    $routes['product.store'] = setRoute('post', '/product/store', 'ProductController@store');
    $routes['product.edit'] = setRoute('get', '/product/edit/{id}', 'ProductController@edit');
    $routes['product.update'] = setRoute('post', '/product/update/{id}', 'ProductController@update');
    $routes['product.delete'] = setRoute('delete', '/product/delete{id}', 'ProductController@delete');

    $routes['api.product.index'] = setRoute('get', '/api/product/paginate', 'ProductController@index');

    return $routes;