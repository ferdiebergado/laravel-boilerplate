<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExceptionReportMail;
use Whoops\Run as Whoops;
use Whoops\Handler\PrettyPageHandler;

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
        'old_password',
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
        if ($this->shouldReport($exception)) {
            $whoops = new Whoops();
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            $whoops->pushHandler(new PrettyPageHandler());
            $body = $whoops->handleException($exception);
            Mail::to(config('app.email'))->send(new ExceptionReportMail($body));
        }
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
        if (($exception instanceof \Illuminate\Session\TokenMismatchException) || ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException)) {
            return redirect()
                    ->back()
                    ->withInput($request->except([
                        'password',
                        'password_confirmation',
                        'old_password',
                        '_token'
                    ]))
                    ->with([
                        'error' => 'The session has expired. Please try again.'
                    ]);
        }

        // if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        //     return redirect()->back()->withErrors($exception->getMessage())->withInput();
        // }

        return parent::render($request, $exception);
    }
}
