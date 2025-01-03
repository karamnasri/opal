<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class VerificationCodeExpiredException extends Exception
{
    use HandlesExceptionResponse;
    public function __construct()
    {
        $this->setMessage('The verification code has expired. A new one has been sent.')
            ->setCode(400);
    }
}
