<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use App\Traits\HandlesExceptionResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            if (in_array(HandlesExceptionResponse::class, class_uses($e))) {
                return $e->render();
            }

            return $this->errorResponse(
                $e->getMessage() ?: 'An unexpected error occurred',
                $e->getCode() ?: 500
            );
        }

        return parent::render($request, $e);
    }
}
