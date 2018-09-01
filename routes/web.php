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
    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/friends', 'FriendController@friends')->name('friends.index');
    Route::group(['prefix' => 'api'], function () {
        Route::get('friends/{username?}', 'FriendController@searchUser')->name('friends.search');
        Route::post('news/', 'NewsController@store')->name('news.store');
        Route::get('news/list', 'NewsController@index')->name('news.list');
        Route::get('news/read/{id}', 'NewsController@read')->where('id', '[0-9]+')->name('news.read');
        Route::post('news/process', 'NewsController@process')->name('news.process');
    });

    Route::get('/chat/{user_id}', 'ChatController@chat')->where('user_id', '[0-9]+');
    Route::post('/chat/upload', 'ChatController@uploadImg')->name('chat.upload');
    Route::post('/chat/save', 'ChatController@save');
});

Route::any('/login', 'PublicController@login')->name('login');
Route::any('/register', 'PublicController@register')->name('register');
Route::get('/logout', 'PublicController@logout')->name('logout');