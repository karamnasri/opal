<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Success response method.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function successResponse($data, $message = 'Request was successful', $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Error response method.
     *
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     * @return JsonResponse
     */
    public function errorResponse($message, $statusCode = 400, $errors = []): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Validation error response.
     *
     * @param $validator
     * @return JsonResponse
     */
    public function validationErrorResponse($validator): JsonResponse
    {
        return $this->errorResponse(
            'Validation error',
            422,
            $validator->errors()
        );
    }

    /**
     * Redirect response method.
     *
     * @param string $redirectUrl
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function redirectResponse($redirectUrl, $message = 'Redirecting', $statusCode = 302): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'redirect_url' => $redirectUrl
        ], $statusCode);
    }
}
