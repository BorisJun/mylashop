<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ( !$request->user()->email_verified ) {
            // 判断是否是AJAX请求
            if ( $request->expectsJson() ) {
                return response()->json(['msg'=>'请先验证邮箱'], 400);
            }
            // 跳转到邮箱验证页面
            return redirect(route('email_verify_notice'));
        }
        return $next($request);
    }
}
