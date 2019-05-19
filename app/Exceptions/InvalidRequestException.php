<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class InvalidRequestException extends Exception
{
    public function __construct( string $message = "", int $code = 400, Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * 一旦异常被触发，执行 render() 方法
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function render( Request $request )
    {

        if ( $request->expectsJson() ) {
            return response()->json(['msg'=>$this->getMessage()], $this->getCode());
        }
        return view('pages.error', ['msg'=>$this->getMessage()]);
    }
}
