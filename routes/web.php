<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'login'], function () {
    Route::get('/', 'IndexController@index');
    Route::group(['prefix' => 'api'], function () {
        Route::get('friends/{username?}', 'FriendsController@searchUser');
        Route::post('news/', 'NewsController@store');
        Route::get('news/read/{id}', 'NewsController@read')->where('id', '[0-9]+');
        Route::post('news/process', 'NewsController@process');
    });

    Route::get('/chat/{user_id}', 'ChatController@chat')->where('user_id', '[0-9]+');
});

Route::any('/login', 'PublicController@login');
Route::any('/register', 'PublicController@register');
Route::any('/logout', 'PublicController@logout');