<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 我们只需要通过邮件通知，因此这里只需要一个 mail
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * 发送邮件时会调用此方法来构建邮件内容
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable App\Models\User 对象
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        // 保存邮件发送相关信息
        // 使用Laravel内置Str类生成随机字符串
        $token = Str::random().uniqid();
        // 写入缓存 30分钟
        $expireTime = 30;
        Cache::set('email_verification_'.$notifiable->email, $token, $expireTime);

        $url = route('email_verification.verify', ['email'=>$notifiable->email, 'token'=>$token]);
        return (new MailMessage)
                    ->greeting( $notifiable->name.'您好：' )
                    ->subject('恭喜，注册成功，请验证您的邮箱')
                    ->line('请点击下方链接验证您的邮箱')
                    ->action('验证', $url)
                    ->line('感谢您的关注，我们将竭力服务。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
