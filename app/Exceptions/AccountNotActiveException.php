<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class AccountNotActiveException extends Exception
{
    use ApiResponseTrait;

    protected $message = 'Account is not active. Please contact support.';
    protected $code = 403;

    /**
     * Render the exception to the HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): JsonResponse
    {
        return $this->errorResponse($this->getMessage(), $this->getCode(), ['action' => 'contact_support_page']);
    }
}
