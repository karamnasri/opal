<?php

namespace App\DTOs\Auth;

use App\Models\User;
use App\Traits\DtoRequestTrait;
use DateTime;

class RegisterDTO
{
    use DtoRequestTrait;

    public string $name;
    public string $email;
    public string $password;
    public TokenPairDTO $tokens;
    public bool $verify = false;
}
