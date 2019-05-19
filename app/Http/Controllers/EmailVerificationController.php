<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmailVerificationController extends Controller
{
    /**
     * 用户手动触发邮件事件
     * @param Request $request
     */
    public function send( Request $request )
    {
        $user = $request->user();
        if ( $user->email_verified ) {
            throw new InvalidRequestException('你已经验证过了');
        }
        // 调用 notify() 方法用来发送我们定义好的通知类
        $user->notify( new EmailVerificationNotification() );

        return view('pages.success', ['msg'=>'邮件发送成功']);
    }

    /**
     * 验证邮箱是否校验通过
     * @param Request $request
     * @throws InvalidRequestException
     */
    public function verify( Request $request )
    {
        $email = $request->input('email');
        $token = $request->input('token');
        if ( !$email || !$token ) {
            throw new InvalidRequestException('验证链接有误');
        }

        // 判断对应缓存是否存在
        if ( !Cache::get('email_verification_'.$email) || Cache::get('email_verification_'.$email) != $token ) {
            throw new Exception('验证链接不正确或链接过期');
        }

        // 验证用户是否存在
        if ( !$user = User::where(['email'=>$email])->first() ) {
            throw new InvalidRequestException('用户不存在');
        }

        // 校验通过 删除缓存
        Cache::forget('email_verification_'.$email);

        // 修改用户状态【置为已验证】
        $user->update(['email_verified'=>true]);

        // 显示验证成功页面
        return view('pages.success', ['msg'=>'恭喜，验证成功']);
    }
}
