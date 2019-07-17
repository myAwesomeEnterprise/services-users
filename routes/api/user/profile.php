<?php

Route::prefix('/users/profile/{user}')
    ->namespace('User')
    ->group(function () {
        Route::get('/', 'ProfileController@get');
        Route::put('/', 'ProfileController@update');
        Route::put('/password', 'ProfileController@updatePassword');
        Route::delete('/', 'ProfileController@destroy');
    });
