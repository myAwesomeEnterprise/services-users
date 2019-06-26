<?php

Route::prefix('admin')
    ->namespace('User')
    ->middleware('auth:api')
    ->group(function () {
        Route::prefix('abilities')->middleware('userCan:admin-abilities')->group(function () {
            Route::get('/user/{user}', 'AbilityController@getAbilitiesOfUser');

            Route::get('/', 'AbilityController@all');
            Route::post('/', 'AbilityController@store');
            Route::get('/{ability}', 'AbilityController@get');
            Route::put('/{ability}', 'AbilityController@update');
            Route::delete('/{ability}', 'AbilityController@destroy');
            Route::get('/{ability}/roles', 'AbilityController@roles');
            Route::get('/{ability}/users', 'AbilityController@users');
        });

        Route::prefix('ability')->middleware('userCan:admin-abilities')->group(function () {
            Route::post('/to', 'AbilityController@user');
            Route::post('/model', 'AbilityController@model');
            Route::post('/entity', 'AbilityController@entity');
            Route::post('/everything', 'AbilityController@everything');

            Route::post('/manage/model', 'AbilityController@manageModel');
            Route::post('/manage/entity', 'AbilityController@manageEntity');

            Route::post('/own/model', 'AbilityController@ownModel');
            Route::post('/own/everything', 'AbilityController@ownEverything');
        });

        Route::prefix('roles')->middleware('userCan:admin-roles')->group(function () {
            Route::post('/user', 'RoleController@assignUser');
            Route::get('/user/{user}', 'RoleController@getRolesOfUser');

            Route::get('/', 'RoleController@all');
            Route::post('/', 'RoleController@store');
            Route::get('/{role}', 'RoleController@get');
            Route::put('/{role}', 'RoleController@update');
            Route::delete('/{role}', 'RoleController@destroy');
            Route::post('/{role}/ability', 'RoleController@ability');
            Route::get('/{role}/abilities', 'RoleController@abilities');
            Route::get('/{role}/users', 'RoleController@users');
        });
    });
