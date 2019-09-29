<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // 用户管理
    $router->get('users', 'UsersController@index')->name('admin.users.index');
    $router->get('users/create', 'UsersController@create')->name('admin.users.create');
    $router->post('users', 'UsersController@store')->name('admin.users.store');
    $router->get('users/{user}/edit', 'UsersController@edit')->name('admin.users.edit');
    $router->put('users/{user}', 'UsersController@update')->name('admin.users.update');
    $router->get('users/{user}', 'UsersController@show')->name('admin.users.show');

    // 订单管理
    $router->get('orders', 'OrdersController@index')->name('admin.orders.index');;
    $router->get('orders/{id}', 'OrdersController@show')->name('admin.orders.show');
    $router->get('orders/{id}/edit', 'OrdersController@edit')->name('admin.orders.edit');
    $router->put('orders/{id}', 'OrdersController@update')->name('admin.orders.update');

    // 支付管理
    $router->get('payments', 'PaymentsController@index')->name('admin.payments.index');
    $router->get('payments/create', 'PaymentsController@create')->name('admin.payments.create');
    $router->post('payments', 'PaymentsController@store')->name('admin.payments.store');
    $router->get('payments/{payment}/edit', 'PaymentsController@edit')->name('admin.payments.edit');
    $router->put('payments/{payment}', 'PaymentsController@update')->name('admin.payments.update');
    $router->get('payments/{payment}', 'PaymentsController@show')->name('admin.payments.show');

    // 销售管理
    $router->resource('sales-datas', SalesDatasController::class);

    // 微信号
    $router->resource('wechats', WechatsController::class);

    // 进线计划
    $router->get('enter-plans','EnterPlansController@index');
    $router->put('enter-plans/{wechat_to_channels}','EnterPlansController@update')->name('admin.enter.plans.update');

    // 渠道
    $router->resource('channels', ChannelsController::class);
    $router->post('channels/check_channel','ChannelsController@check_channel');
    $router->post('channels/add_channel','ChannelsController@add_channel');
//    $router->post('channels/check_channel','ChannelsController@check_channel');
//    $router->post('channels/add_channel','ChannelsController@add_channel')->name('admin.channels.add');
//    $router->resource('channel-assgins', ChannelAssginsController::class);

    // 进线管理
//    $router->get('enter-plans/enter_data','EnterPlansController@enter_data');
//    $router->resource('enter-plans', EnterPlansController::class);

    $router->resource('plans', PlansController::class);
    $router->post('plans/add_plans','PlansController@add_plans');
    $router->post('plans/data_plans','PlansController@data_plans');
    $router->post('plans/clear','PlansController@clear');
});
