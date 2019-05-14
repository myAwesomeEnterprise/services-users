<?php

Route::middleware('auth:api')
    ->namespace('User')
    ->prefix('admin/users')
    ->group(function() {

    Route::get('/', 'UserController@all')
        ->middleware('userCan:read-all-users');

    Route::get('/search', 'UserController@search')
        ->middleware('userCan:read-all-users');

    Route::get('/{user}', 'UserController@get')
        ->middleware('userCan:read-detail-user');

    Route::post('/', 'UserController@store')
        ->middleware('userCan:create-user');

    Route::put('/{user}', 'UserController@update')
        ->middleware('userCan:update-user');

    Route::delete('/{user}', 'UserController@destroy')
        ->middleware('userCan:delete-user');

});
