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

Route::post('/reg_check', 'Auth\RegisterController@reg_check')->name('reg_check');
Route::resource('article', 'ArticleController');
Route::get('goods/search', 'GoodsController@search')->name('goods.search');
Route::resource('goods', 'GoodsController', ['only' => ['index', 'show']]);
Route::resource('article', 'ArticleController', ['only' => ['index', 'show']]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('order/ddgz', 'OrderController@ddgz')->name('order.ddgz');
    Route::resource('order', 'OrderController');
    Route::delete('collect_goods/plsc', 'CollectGoodsController@plsc')->name('collect_goods.plsc');
    Route::resource('collect_goods', 'CollectGoodsController', ['only' => ['index', 'destroy', 'store']]);
    Route::resource('youhuiq', 'YouhuiqController', ['only' => ['index']]);


    Route::get('zncg', 'UserController@zncg')->name('user.zncg');
    Route::get('account_log', 'UserController@account_log')->name('user.account_log');
    Route::get('profile', 'UserController@profile')->name('user.profile');
    Route::get('pswl', 'UserController@pswl')->name('user.pswl');
    Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');
    Route::put('user', 'UserController@update')->name('user.update');
    Route::resource('user', 'UserController', ['only' => ['index']]);
    Route::get('cart/choose', 'CartController@choose');
    Route::get('cart/jiesuan', 'CartController@jiesuan')->name('cart.jiesuan');
    Route::post('cart/addNum', 'CartController@addNum');
    Route::resource('cart', 'CartController');
    Route::resource('address', 'AddressController');
    Route::get('get_region_list', 'CommonController@get_region_list')->name('get_region_list');
});
