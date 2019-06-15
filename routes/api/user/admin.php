<?php

Route::middleware('auth:api')
    ->namespace('User')
    ->prefix('admin/users')
    ->group(function () {
        Route::post('/{user}/send-verification-email', 'VerificationController@sendEmail')
            ->middleware('userCan:send-verification-email');

        Route::post('/{user}/deactivate', 'VerificationController@deactivate')
            ->middleware('userCan:deactivate-account');

        Route::post('/{user}/activate', 'VerificationController@activate')
            ->middleware('userCan:activate-account');

        Route::post('/{user}/ban', 'BanController@ban')
            ->middleware('userCan:ban-account');

        Route::post('/{user}/unban', 'BanController@unBan')
            ->middleware('userCan:unban-account');
    });
