<?php

// /api/auth
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController');

    Route::group(['middleware' => ['auth.api']], function () {
        Route::get('me', 'MeController');
        Route::post('logout', 'LogoutController');
    });
});

// /api/quizzes
Route::group(['prefix' => 'quizzes', 'namespace' => 'Quiz'], function () {
    Route::get('', 'QuizController@index');
    Route::get('{id}', 'QuizController@show');

    Route::group(['middleware' => ['auth.api']], function () {
        Route::post('', 'QuizController@store');
        Route::put('{id}', 'QuizController@update');
        Route::delete('{id}', 'QuizController@delete');
    });
});
