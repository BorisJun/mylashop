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
//       Route::get('/test',  function() {
//           return 'Your email is verified';
//       });
    });
    // 结束
});


