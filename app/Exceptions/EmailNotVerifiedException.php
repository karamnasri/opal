<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class EmailNotVerifiedException extends Exception
{
    use ApiResponseTrait;
    protected $message = 'Email is not verified';
    protected $code = 403;

    /**
     * Render the exception to the HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): JsonResponse
    {
        return $this->errorResponse($this->getMessage(), $this->getCode(), ['action' => 'reopen_verification_page']);
    }
}
