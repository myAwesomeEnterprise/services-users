<?php

Route::namespace('Auth')
    ->prefix('auth')
    ->group(function () {
        Route::post('/register', 'ApiRegisterController@register');
        Route::post('/token', 'ApiLoginController@login');
        Route::post('/refresh-token', 'ApiRefreshController@refresh');
        Route::post('/logout', 'LogoutController@logout');  // validate
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('/password/reset', 'ResetPasswordController@reset');
        Route::post('/is-valid', 'CheckTokenController@check'); // validate
    });
