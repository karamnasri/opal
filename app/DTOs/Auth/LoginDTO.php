<?php

namespace App\DTOs\Auth;

use App\Models\Customer;
use App\Models\User;
use App\Traits\DtoRequestTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

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
