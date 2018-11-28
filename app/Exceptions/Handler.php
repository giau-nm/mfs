<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
        if ($exception instanceof HttpResponseException) {
            return $exception->getResponse();
        } elseif ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException($exception->getMessage(), $exception);
        } elseif ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        } elseif ($exception instanceof AuthorizationException) {
            $exception = new HttpException(403, $exception->getMessage());
        } elseif ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return $this->unAuthorization($request, $exception);
        } elseif ($exception instanceof ValidationException && $exception->getResponse()) {
            return $exception->getResponse();
        }

        if ($this->isHttpException($exception)) {
            return $this->toIlluminateResponse($this->renderHttpException($exception), $exception);
        } else {
            return $this->toIlluminateResponse($this->convertExceptionToResponse($exception), $exception);
        }
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => STATUS_ERROR, 'message' => 'Unauthenticated.'], 401);
        }
 
        return redirect()->guest(route('user.logout'));
    }

    protected function unAuthorization($request, \Illuminate\Auth\Access\AuthorizationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => STATUS_ERROR, 'message' => 'Unauthorization.'], 401);
        }
 
        return redirect()->guest(route('user.logout'));
    }
}
