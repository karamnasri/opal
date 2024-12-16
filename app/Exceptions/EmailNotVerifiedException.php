<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class EmailNotVerifiedException extends Exception
{
    use HandlesExceptionResponse;
    public function __construct()
    {

        $this->setMessage('Email is not verified.')
            ->setCode(403)
            ->setErrors(['action' => 'reopen_verification_page']);
    }
}
