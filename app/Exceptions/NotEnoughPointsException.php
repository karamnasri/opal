<?php

namespace App\Exceptions;

use App\Traits\HandlesExceptionResponse;
use Exception;

class NotEnoughPointsException extends Exception
{
    use HandlesExceptionResponse;

    public function __construct(int $required, int $available)
    {
        $this->setMessage("You need {$required} points, but only have {$available}.")
            ->setCode(422)
            ->setErrors([
                'points' => 'Insufficient design points for this purchase.'
            ]);
    }
}
