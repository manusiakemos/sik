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

Route::get('/', 'FrontendController@admin')->name('login');

//Route::get('/', 'FrontendController@home');

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

// Route::post('sociallogin/{provider}', 'AuthController@SocialSignup');
// Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');
