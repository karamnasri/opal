<?php

namespace App\DTOs\Auth;

use App\Traits\DtoRequestTrait;

class VerifyDTO
{
    use DtoRequestTrait;

    public string $email;
    public string $verification_code;
}
