<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Auth\LoginAPIController@login')->name('login');
Route::post('register', 'Auth\RegisterAPIController@register')->name('register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'Auth\LogoutAPIController@logout')->name('logout');
    Route::get('user', 'Auth\GetAuthUserAPIController@getAuthUser')->name('user');

});
