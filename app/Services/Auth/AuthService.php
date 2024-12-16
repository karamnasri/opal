<?php

namespace App\Services\Auth;

use App\Contracts\Authenticatable;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Exceptions\AccountNotActiveException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService implements Authenticatable
{
    public function register(RegisterDTO $dto)
    {
        $user = User::createUser($dto->toArray());
        $user->sendVerificationEmail();
        return $user;
    }

    public function login(LoginDTO $dto)
    {
        if (!Auth::attempt($dto->credentials())) {
            throw new \Exception('Invalid credentials', 401);
        }

        $dto->user = Auth::user();

        if ($dto->user->email_verified_at) {
            $dto->verify = true;
        }

        if (!$dto->user->isActive()) {
            throw new AccountNotActiveException();
        }

        $dto->token = $dto->user->token();

        return $dto;
    }

    public function logout()
    {
        Auth::user()?->currentAccessToken()->delete();
    }
}
