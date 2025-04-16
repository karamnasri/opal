<?php

namespace App\DTOs\Auth;

use App\Traits\DtoRequestTrait;

class LoginDTO
{
    use DtoRequestTrait;
    public string $email;
    public string $password;
    public TokenPairDTO $tokens;
    public bool $verify = false;

    public function credentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
