<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class
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

    public function report(\Throwable $exception)
    {
        Log::error(
            sprintf(
                "\r\n[%d] %s: %s in %s:%d\r\n",
                $exception->getCode(),
                get_class($exception),
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            ),
            ['breakpoint' => 'error']
        );
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

    }

    public function render($request, \Throwable $exception)
    {
        return BaseException::renderByJson($request, $exception);
    }
}
