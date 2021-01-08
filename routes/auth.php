<?php
Route::group(
    ['namespace' => 'Auth', 'prefix' => 'auth'],
    static function () {
        Route::post('signup', 'AuthController@signUp');
        Route::post('signin', 'AuthController@signIn');
    }
);
