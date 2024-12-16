<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class AccountNotActiveException extends Exception
{
    use HandlesExceptionResponse;
    public function __construct()
    {
        $this->setMessage('Account is not active. Please contact support.')
            ->setCode(403)
            ->setErrors(['action' => 'contact_support_page']);
    }
}
