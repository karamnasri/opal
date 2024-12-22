<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class AuthException extends Exception
{
    use HandlesExceptionResponse;
    public function __construct()
    {

        $this->setMessage('Unauthenticated. Please log in to continue.')
            ->setCode(401);
    }
}
