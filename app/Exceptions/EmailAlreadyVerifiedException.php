<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class EmailAlreadyVerifiedException extends Exception
{
    use HandlesExceptionResponse;
    public function __construct()
    {

        $this->setMessage('Email is already verified.')
            ->setCode(409);
    }
}
