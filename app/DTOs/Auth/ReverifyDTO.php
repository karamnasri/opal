<?php

namespace App\DTOs\Auth;

use App\Traits\DtoRequestTrait;

class ReverifyDTO
{
    use DtoRequestTrait;
    public string $email;
}
