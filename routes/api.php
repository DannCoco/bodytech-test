<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
|
|---------------------------------------------------------------------------
| INDEX TABLE
|---------------------------------------------------------------------------
| 1. Auth
| 2. Cart
| 3. Product
|
*/

/** Auth */
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('register', 'Auth\AuthController@register');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('user', 'Auth\AuthController@user');
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    /** Cart */
    Route::resource('cart', 'Carts\CartsController')->except(['create', 'edit', 'destroy']);
});

/** Product */
Route::resource('product', 'Products\ProductsController')->except(['create', 'edit']);
