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
*/

Route::post('login', 'API\ApiController@login');
Route::post('register', 'API\ApiController@register');
 
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'API\ApiController@logout');
 
    Route::get('user', 'API\ApiController@getAuthUser');

    Route::Resource('users', 'API\UserController')->middleware('admin');
    Route::Resource('categories', 'API\CategoryController')->middleware('admin');
 	Route::Resource('products', 'API\ProductController')->middleware('admin');

 	Route::Resource('cart', 'API\CartController');
	Route::Resource('orders', 'API\OrderController');

});

Route::get('getProductsByCategory/{category_id}', 'API\ProductController@getProductsByCategory');