<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/productList', 'GuestUserController@productListView')->name('productList');

Route::group(['middleware' => ['auth']], function () {
	Route::Resource('categories', 'CategoryController')->middleware('admin');
	Route::Resource('products', 'ProductController')->middleware('admin');
	Route::Resource('users', 'UserController')->middleware('admin');
	Route::Resource('cart', 'CartController');
	Route::Resource('orders', 'OrderController');
	Route::get('index_new', 'OrderController@index_new');
	//show_data
	Route::get('show_data', 'OrderController@show_data')->name('show_data');
	Route::post('deleteOrder', 'OrderController@delete')->name('deleteOrder');
});
Route::get('registration', 'CategoryController@types')->name('registration');

Route::get('getProductPrice', 'ProductController@getProductPrice');
Route::get('getProductsByCategory', 'ProductController@getProductsByCategory');
Route::get('getProductsView', 'ProductController@getProductsView');
