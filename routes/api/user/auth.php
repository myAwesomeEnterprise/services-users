<?php

Route::namespace('Auth')->group(function() {
    Route::post('/register','ApiRegisterController@register');
    Route::post('/logout', 'LogoutController@logout');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
});
