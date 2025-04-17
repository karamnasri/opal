<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class AllItemsAlreadyOwnedException extends Exception
{
    use HandlesExceptionResponse;

    public function __construct()
    {
        $this->setMessage('All items in your cart are already purchased.')
            ->setCode(400)
            ->setErrors([]);
    }
}
