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

// /api/questions
Route::group(
    [
        'prefix' => 'questions',
        'namespace' => 'Question',
        'middleware' => ['auth.api'],
    ],
    function () {
        Route::get('', 'QuestionController@index');
        Route::post('', 'QuestionController@store');
        Route::get('{id}', 'QuestionController@show');
        Route::put('{id}', 'QuestionController@update');
        Route::delete('{id}', 'QuestionController@delete');
    }
);

// /api/answers
Route::group(
    [
        'prefix' => 'answers',
        'namespace' => 'Answer',
        'middleware' => ['auth.api'],
    ],
    function () {
        Route::get('', 'AnswerController@index');
        Route::post('', 'AnswerController@store');
        Route::get('{id}', 'AnswerController@show');
        Route::put('{id}', 'AnswerController@update');
        Route::delete('{id}', 'AnswerController@delete');
    }
);

// /api/users
Route::group(
    [
        'prefix' => 'users',
        'namespace' => 'User',
        'middleware' => ['auth.api', 'admin'],
    ],
    function () {
        Route::get('', 'UserController@index');
        Route::post('', 'UserController@store');
        Route::get('{id}', 'UserController@show');
        Route::put('{id}', 'UserController@update');
        Route::delete('{id}', 'UserController@delete');
    }
);
