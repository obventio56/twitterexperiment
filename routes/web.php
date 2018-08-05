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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/timeline', 'HomeController@index')->name('timeline')->middleware('auth');
Route::get('twitter/logout', 'Auth\LoginController@twitterLogout')->name('twitter-logout');

Route::get('login/twitter', 'Auth\LoginController@redirectToProvider')->name('twitter-login');
Route::get('login/twitter/callback', 'Auth\LoginController@handleProviderCallback');

