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
        /**
         * 簡化錯誤報告的內容，方便定位至錯誤位置
         * runningInConsole => 用指令執行 phpunit 時拋出錯誤使測試斷言接收 exception
         * 補充 : 在 tests/TestCase.php 中改寫了拋出異常的方式，故此處不會有影響。
         */
        // if(app()->environment() === 'local' && app()->runningInConsole()) throw $exception;

        return parent::render($request, $exception);
    }
}
