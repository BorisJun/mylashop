<?php

namespace App\Listeners;

use App\Notifications\EmailVerificationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// implements ShouldQueue 异步执行监听器
class RegisteredListener implements ShouldQueue
{
    /**
     * 当事件被触发时，对应该事件的监听器的 handle() 方法就会被调用
     *
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle( Registered $event)
    {
        // 获取刚刚注册的用户
        $user = $event->user;
        // 调用 notify 发送通知
        $user->notify( new EmailVerificationNotification() );
    }
}
