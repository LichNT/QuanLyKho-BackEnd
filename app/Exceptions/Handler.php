<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedException) {
            if ($exception->getMessage() == "token_expire") {
                return response([
                    'code' => 'token_expire',
                    'message' => 'Phiên làm việc của bản đã hết hạn, vui lòng đăng nhập lại để sử dụng hệ thống!'
                ], 401);
            } else {
                return response([
                    'code' => 'unauthorized',
                    'message' => 'Phiên đăng nhập của bản đã hết hạn, vui lòng đăng nhập lại để sử dụng hệ thống!'
                ], 401);
            }

        }
        return parent::render($request, $exception);
    }
}
