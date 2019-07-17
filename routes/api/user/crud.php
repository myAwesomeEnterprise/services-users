<?php

Route::namespace('User')
    ->prefix('/users')
    ->group(function () {
        Route::get('/', 'UserController@all');
        Route::get('/search', 'UserController@search');
        Route::get('/{user}', 'UserController@get');
        Route::post('/', 'UserController@store');
        Route::put('/{user}', 'UserController@update');
        Route::delete('/{user}', 'UserController@destroy');
    });
