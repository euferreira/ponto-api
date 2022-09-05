<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
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
     * @param Throwable $e
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response|JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        switch ($e->getCode()) {
            case 400:
                return response()->json([
                    'message' => 'Bad Request',
                    'trace' => $e->getMessage(),
                ], 400);

            case 404:
                return response()->json([
                    'message' => 'Not found',
                    'trace' => $e->getMessage(),
                ], 404);

            default:
                return response()->json([
                    'message' => 'Internal server error',
                    'trace' => $e->getMessage(),
                    'code' => $e->getCode(),
                ], 500);
        }
    }
}
