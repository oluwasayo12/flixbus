<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            return $this->buildResponse($e);
        });
    }

    /**
     * @param Throwable $e
     * @param null $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function buildResponse(Throwable $e, $request = null)
    {
        if ($e instanceof ValidationException) {
            return $this->formValidationErrorAlert('Validation error occurred', Arr::flatten($e->errors()));
        }
        if ($e instanceof AuthenticationException) {
            return $this->badRequestAlert($e->getMessage());
        }
        if ($e instanceof ModelNotFoundException) {
            return $this->notFoundResponse('Model cannot be found');
        }
        if ($e instanceof NotFoundHttpException) {
            return $this->clientError($e->getMessage() || "Resource cannot be found", 404);
        }
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }
        if ($e instanceof HttpException) {
            return $this->jsonResponse($e->getMessage(), $e->getStatusCode());
        }

        return $this->serverErrorAlert($e->getMessage());
    }
}
