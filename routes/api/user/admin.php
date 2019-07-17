<?php

Route::namespace('User')
    ->prefix('/users')
    ->group(function () {
        Route::post('/{user}/send-verification-email', 'VerificationController@sendEmail');
        Route::post('/{user}/deactivate', 'VerificationController@deactivate');
        Route::post('/{user}/activate', 'VerificationController@activate');
        Route::post('/{user}/ban', 'BanController@ban');
        Route::post('/{user}/unban', 'BanController@unBan');
    });
