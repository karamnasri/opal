<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class EmptyCartException extends Exception
{
    use HandlesExceptionResponse;

    public function __construct()
    {
        $this->setMessage('Your cart is empty.')
            ->setCode(400)
            ->setErrors([]);
    }
}
