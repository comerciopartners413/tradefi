<?php

namespace TradefiUBA\Exceptions;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof \Illuminate\Contracts\Encryption\DecryptException) {
            return response()->json(['success' => false, 'message' => 'Maco'], 200);
        } else {
            parent::report($exception);
        }

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

        if ($exception instanceof \Illuminate\Contracts\Encryption\DecryptException) {
            return response()->json(['message' => 'Expired Pin. Kindly reset it to continue'])->setStatusCode(500, 'Expired Pin. Kindly reset your trading pin to continue');
        } else {
            return parent::render($request, $exception);
        }

    }
}
