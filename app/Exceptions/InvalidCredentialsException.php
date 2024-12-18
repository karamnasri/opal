<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class InvalidCredentialsException extends Exception
{
    use HandlesExceptionResponse;

    public function __construct()
    {
        $this->setMessage('Invalid credentials.')
            ->setCode(401);
    }
}
