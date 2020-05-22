<?php

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController');

    Route::group(['middleware' => ['auth.api']], function () {
        Route::get('me', 'MeController');
        Route::post('logout', 'LogoutController');
    });
});
