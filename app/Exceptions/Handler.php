<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Exceptions\ValidationException as ServiceValidationException;
use Exception;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ServiceValidationException) {
            return response()->json([
                'error' => true,
                'category' => $exception->getCategory(),
                'message' => $exception->getUserMessage(),
                'data' => $exception->getErrors()
            ], $exception->getStatus());
        }

        if($exception instanceof UserException) {
            return response()->json([
                'error' => true,
                'category' => $exception->getCategory(),
                'message' => $exception->getUserMessage(),
                'data' => []
            ], $exception->getStatus());
        }

        return response()->json([
            'error' => true,
            'category' => InternalServerException::CATEGORY,
            'message' => InternalServerException::USER_MESSAGE,
            'data' => []
        ], InternalServerException::STATUS);
    }
}
