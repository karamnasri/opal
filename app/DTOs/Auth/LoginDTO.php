<?php

namespace App\DTOs\Auth;

use App\Models\User;
use App\Traits\DtoRequestTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class LoginDTO
{
    use DtoRequestTrait;
    public string $email;
    public string $password;
    public User&Authenticatable $user;
    public string $token;
    public bool $verify = false;

    public function credentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function fillDTO()
    {
        $this->verify = (bool) $this->user->email_verified_at;
        $this->token = $this->user->token();
    }
}
