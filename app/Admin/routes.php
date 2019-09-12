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

    // 支付管理
    $router->get('payments', 'PaymentsController@index')->name('admin.payments.index');
    $router->get('payments/create', 'PaymentsController@create')->name('admin.payments.create');
    $router->post('payments', 'PaymentsController@store')->name('admin.payments.store');
    $router->get('payments/{payment}/edit', 'PaymentsController@edit')->name('admin.payments.edit');
    $router->put('payments/{payment}', 'PaymentsController@update')->name('admin.payments.update');
    $router->get('payments/{payment}', 'PaymentsController@show')->name('admin.payments.show');

    // 进线管理
    $router->resource('enter-plans', EnterPlansController::class);

    // 销售管理
    $router->resource('sales-datas', SalesDatasController::class);

    // 微信公众号
    //$router->resource('wx-qrcodes', WxQrcodesController::class);
    //$router->resource('plans', PlanController::class);
});
