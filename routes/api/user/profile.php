<?php

Route::prefix('user/profile/{user}')
    ->middleware('auth:api', 'isOwns:admin-profile')
    ->namespace('User')
    ->group(function () {
        Route::get('/', 'ProfileController@get');
        Route::put('/', 'ProfileController@update');
        Route::put('/password', 'ProfileController@updatePassword');
        Route::delete('/', 'ProfileController@destroy');
    });
