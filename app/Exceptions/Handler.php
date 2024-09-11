<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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

    public function render($request, Throwable $exception)
    {
        dd($exception);
        $retval = parent::render($request, $exception);

        if (!(strpos($request->getUri(), '/api'))) {
            return $retval;
        } else {
            return response()->json(
                [
                    'success' => false,
                    'exception' => 1,
                    'message' => $exception->getMessage(),
                    'errors' => $exception,
                    'url' => $request->getUri(),
                    'request' => json_encode(request()->all(), JSON_PRETTY_PRINT),
                    'trace' => $exception->getTrace(),
                ],
                500
            );
        }
        return $retval;
    }
}
