<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class InternalException extends Exception
{
    protected $msgForUser;

    public function __construct( string $message = "", string $msgForUser = '系统内部错误', $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->msgForUser = $msgForUser;
    }

    public function render( Request $request )
    {
        /**
         * 判断开发环境 如果是开发或测试 则显示详细信息；线上返回内部错误
         */
        if ( env('APP_DEBUG') ) {
            // 开发环境
            if ( $request->expectsJson() ) {
                return response()->json(['msg'=>$this->getMessage(), 'code'=>$this->getCode()], $this->getCode());
            }
            return view('pages.error', ['msg'=>$this->getMessage()]);
        } else {
            // 生产环境
            if ( $request->expectsJson() ) {
                return response()->json(['msg'=>$this->msgForUser, 'code'=>$this->getCode()], $this->getCode());
            }
            return view('pages.error', ['msg'=>$this->msgForUser]);
        }
    }
}
