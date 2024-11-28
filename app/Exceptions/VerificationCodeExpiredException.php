<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class VerificationCodeExpiredException extends Exception
{
    use ApiResponseTrait;
    protected $message = 'Verification code has expired.';
    protected $code = 400;

    /**
     * Render the exception to the HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): JsonResponse
    {
        return $this->errorResponse($this->getMessage(), $this->getCode(), ['action' => 'resend_verify_email']);
    }
}
