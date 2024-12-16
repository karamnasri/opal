<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class InvalidVerificationCodeException extends Exception
{
    use HandlesExceptionResponse;
    public function __construct()
    {
        $this->setMessage('The provided verification code is invalid.')
            ->setCode(400);
    }
}
