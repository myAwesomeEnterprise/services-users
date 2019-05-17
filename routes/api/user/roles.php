<?php

Route::prefix('admin')
    ->namespace('User')
    ->middleware('auth:api')
    ->group(function () {
        Route::prefix('ability')->middleware('userCan:admin-abilities')->group(function () {
            Route::get('/user/{user}', 'AbilityController@get');

            Route::post('/', 'AbilityController@store');

            Route::post('/to', 'AbilityController@user');
            Route::post('/model', 'AbilityController@model');
            Route::post('/entity', 'AbilityController@entity');
            Route::post('/everything', 'AbilityController@everything');

            Route::post('/manage/model', 'AbilityController@manageModel');
            Route::post('/manage/entity', 'AbilityController@manageEntity');

            Route::post('/own/model', 'AbilityController@ownModel');
            Route::post('/own/everything', 'AbilityController@ownEverything');
        });

        Route::prefix('role')->middleware('userCan:admin-roles')->group(function () {
            Route::get('/user/{user}', 'RoleController@get');

            Route::post('/', 'RoleController@store');

            Route::post('/ability', 'RoleController@ability');
            Route::post('/user', 'RoleController@user');
        });
    });
