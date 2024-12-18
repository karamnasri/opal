<?php

namespace App\DTOs\Auth;

use App\Models\User;
use App\Traits\DtoRequestTrait;

class ResetPasswordDTO
{
    use DtoRequestTrait;
    public string $email;
    public string $token;
    public string $password;
    public User $user;
}
