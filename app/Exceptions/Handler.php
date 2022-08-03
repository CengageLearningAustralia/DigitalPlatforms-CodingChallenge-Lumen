<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        if ($exception instanceof AuthorizationException) {
            return response()->json(
                ['message' => $exception->getMessage()],
                HttpResponse::HTTP_FORBIDDEN
            );
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json(
                ['message' => "Resource not found for {$request->getPathInfo()}."],
                HttpResponse::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof ModelNotFoundException) {
            // Get model name from class string
            $modelName = substr(strrchr($exception->getModel(), '\\'), 1);
            return response()->json(
                ['message' => "{$modelName} not found."],
                HttpResponse::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $acceptableMethods = implode(',', $exception->getHeaders());

            return response()->json(
                ['message' => "{$request->getMethod()} method not allowed for this resource. Acceptable methods: {$acceptableMethods}."],
                HttpResponse::HTTP_METHOD_NOT_ALLOWED
            );
        }

        if ($exception instanceof HttpException) {
            return response()->json(
                ['message' => $exception->getMessage()],
                $exception->getStatusCode()
            );
        }

        if ($exception instanceof ValidationException) {
            return response()->json(
                ['errors' => $exception->validator->errors()],
                $exception->status
            );
        }

        if (env('APP_DEBUG') === false) {
            return response()->json(
                ['message' => 'A server error has occurred.'],
                HttpResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        
        return parent::render($request, $exception);
    }
}
