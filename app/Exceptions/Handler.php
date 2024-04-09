<?php

namespace App\Exceptions;

use App\Exceptions\Product\ProductIsNotActiveException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ProductIsNotActiveException $e) {
            return responseFailed(__("messages.model_not_found"), 404);
        });
    }

    /**
     * render
     *
     * @param mixed request
     * @param Throwable e
     *
     * @return void
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return responseFailed(__("messages.model_not_found"), 404);
        }
        $this->renderable(function (NotFoundHttpException $e){
            return responseFailed(__("messages.route_not_found"), 404);
        });
        $this->renderable(function (AuthenticationException $e){
            return responseFailed(__("messages.auth_error"), 401);
        });
        return parent::render($request, $e);
    }
}
