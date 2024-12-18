<?php

namespace App\Services\Auth;

use App\Contracts\Authenticatable;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService implements Authenticatable
{
    public function register(RegisterDTO $dto)
    {
        $dto->user = User::createUser($dto->toArray());
        $dto->user->sendVerificationEmail();
        $dto->token = $dto->user->token();
    }

    public function login(LoginDTO $dto)
    {
        $dto->user = User::authenticate($dto->credentials());
        $dto->fillDTO();
        $dto->user->ensureAccountIsActive();
    }

    public function logout()
    {
        Auth::user()?->currentAccessToken()->delete();
    }
}
