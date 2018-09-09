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
    Route::get('/friends', 'FriendController@getFriends')->name('friends.index');
    Route::group(['prefix' => 'api'], function () {
        Route::get('users/{username?}', 'UserController@searchUser')->name('users.search');
        Route::resource('news', 'NewsController', ['only' => ['index', 'store']]);
    });

    Route::resource('users', 'UserController');
    Route::post('/users/avatar', 'UserController@uploadAvatar')->name('users.avatar');

    //  处理好友请求
    Route::post('/news/process/request', 'NewsController@processFriendRequest')->name('news.process_request');

    Route::get('/chat/{user_id}', 'ChatController@chat')->where('user_id', '[0-9]+');
    Route::post('/chat/upload', 'ChatController@uploadImg')->name('chat.upload');
    Route::post('/chat/save', 'ChatController@save');
});

Route::any('/login', 'PublicController@login')->name('login');
Route::any('/register', 'PublicController@register')->name('register');
Route::get('/logout', 'PublicController@logout')->name('logout');