<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');

        $this->actingAs($user);

        return $this;
    }

    /**
     * 默認調用 disableExceptionHandling() 方法，在該方法中，首先將默認的異常處理器記錄到 oldExceptionHandler 屬性中，然後綁定了一個我們自定義的異常處理器到應用中。
     * 在這個自定義的處理器中，我們對 Handler.php 的內容進行了重寫，注意 render() 方法，在我們重寫的該方法中，只會拋出異常，而不是轉化為 HTTP 響應。
     */
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class,new class extends Handler{
            public function __construct(){}
            public function report(\Exception $e){}
            public function render($request,\Exception $e){
                throw $e;
            }
        });
    }

    /**
     * $this當我們不需要拋出異常，而需要得到 HTTP 響應時，繼續調用 withExceptionHandling() 方法，在該方法中，我們重新將默認的異常處理器綁定到應用當中。
     */
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class,$this->oldExceptionHandler);

        return $this;
    }
}
