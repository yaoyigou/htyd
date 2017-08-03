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


Route::get('/', 'IndexController@index')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('cart', 'CartController');
Route::resource('order', 'OrderController');
Route::resource('article', 'ArticleController');
Route::get('goods/search', 'GoodsController@search')->name('goods.search');
Route::resource('goods', 'GoodsController', ['only' => ['index', 'show']]);
Route::resource('account_log', 'AccountLogController', ['only' => ['index', 'show']]);
Route::get('order_info/ddgz', 'OrderInfoController@ddgz')->name('order_info.ddgz');
Route::resource('order_info', 'OrderInfoController', ['only' => ['index', 'show', 'update', 'destroy']]);
Route::resource('collect_goods', 'CollectGoodsController', ['only' => ['index', 'destroy']]);

Route::get('user', 'UserController@index')->name('user.index');
Route::get('user/youhuiq', 'UserController@youhuiq')->name('user.youhuiq');
