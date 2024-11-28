<?php

namespace App\DTOs\Auth;

use App\Models\User;
use App\Traits\DtoRequestTrait;
use Illuminate\Contracts\Auth\Authenticatable;

class LoginDTO
{
    use DtoRequestTrait;
    public string $email;
    public string $password;
    public User&Authenticatable $user;
    public string $token;

    public function credentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
