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


//Auth::routes();

Route::get('login','Auth\LoginController@showLoginForm');
Route::post('login','Auth\LoginController@login')->name('login');
Route::post('logout','Auth\LoginController@logout')->name('logout');

Route::middleware('auth')->group(function (){

    Route::get('/', 'OrdersController@create')->name('/');
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    Route::get('orders/{order}/show','OrdersController@show')->name('orders.show');                    // 订单详情
    Route::get('orders/create', 'OrdersController@create')->name('orders.create');                     // 创建订单
    Route::post('orders', 'OrdersController@store')->name('orders.store');                             // 创建订单
    Route::get('orders/{order}/edit', 'OrdersController@edit')->name('orders.edit');                   // 更新订单
    Route::put('orders/{order}', 'OrdersController@update')->name('orders.update');                    // 更新订单
    Route::get('orders/{order}/logistics','OrdersController@logistics')->name('orders.logistics');      // 订单物流查询


    Route::get('sales', 'SalesDatasController@index')->name('sales.index');
    Route::get('sales/{sale}/show','SalesDatasController@show')->name('sales.show');                    // 订单详情
    Route::get('sales/create', 'SalesDatasController@create')->name('sales.create');                    // 创建订单
    Route::post('sales', 'SalesDatasController@store')->name('sales.store');                            // 创建订单
    Route::get('sales/{sales_data}/edit', 'SalesDatasController@edit')->name('sales.edit');             // 更新订单
    Route::put('sales/{sales_data}', 'SalesDatasController@update')->name('sales.update');              // 更新订单

    Route::get('users/password','UsersController@password')->name('users.password.edit');               // 用户修改密码
    Route::put('users/password/update','UsersController@passwordReset')->name('users.password.update');
});
