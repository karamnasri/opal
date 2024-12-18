<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class InvalidResetTokenException extends Exception
{
    use HandlesExceptionResponse;

    public function __construct()
    {
        $this->setMessage('The password reset token is invalid or has expired.')
            ->setCode(400);
    }
}
