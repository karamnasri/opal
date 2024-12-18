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
    public string $role_id;
    public string $verification_code;
    public DateTime $verification_code_sent_at;
    public User $user;
    public string $token;
    public bool $verify = false;
}
