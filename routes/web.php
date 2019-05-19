<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes( );

Route::get('/', 'PagesController@root')
    ->name('root');

Route::group(['middleware'=>'auth'], function() {
    // 手动触发发送邮件
    Route::get('/email_verification/send', 'EmailVerificationController@send')
        ->name('email_verification.send');

    // 邮箱验证页面
    Route::get('/email_verify_notice', 'PagesController@emailVerifyNotic')
        ->name('email_verify_notice');

    // 邮箱逻辑校验
    Route::get('/email_verification/verify', 'EmailVerificationController@verify')
        ->name('email_verification.verify');

    // 开始验证邮箱
    Route::group(['middleware'=>'email_verified'], function() {

        // 用户收货地址
        Route::get('user_addresses', 'UserAddressesController@index')
            ->name('user_addresses.index');

        // 新增收货地址
        Route::get('user_addresses/create', 'UserAddressesController@create')
            ->name('user_addresses.create');

        // 保存收货地址
        Route::post('user_addresses', 'UserAddressesController@store')
            ->name('user_addresses.store');

        // 修改收货地址页面
        Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')
            ->name('user_addresses.edit');

        // put 保存修改信息
        Route::put('user_addresses/{user_address}', 'UserAddressesController@update')
            ->name('user_addresses.update');

        // 删除收货地址
        Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')
            ->name('user_addresses.destroy');
    });
    // 结束
});


