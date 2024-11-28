<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\ReverifyDTO;
use App\DTOs\Auth\VerifyDTO;
use App\Exceptions\AccountNotActiveException;
use App\Exceptions\EmailNotVerifiedException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService implements AuthServiceInterface
{
    public function register(RegisterDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            $user = User::createUser($dto->toArray());
            $user->sendVerificationEmail();

            return $user;
        });
    }

    public function login(LoginDTO $dto)
    {
        if (!Auth::attempt($dto->credentials())) {
            throw new \Exception('Invalid credentials', 401);
        }

        $dto->user = Auth::user();

        if (!$dto->user->email_verified_at) {
            throw new EmailNotVerifiedException();
        }

        if (!$dto->user->isActive()) {
            throw new AccountNotActiveException();
        }

        $dto->token = $dto->user->token();

        return $dto;
    }

    public function verify(VerifyDTO $dto)
    {
        $user = User::where('email', $dto->email)->firstOrFail();
        checkVerificationRateLimit($user->id, 5);

        $user->verifyCodeAndExpiration($dto->verification_code);
        $user->markEmailAsVerified();
    }

    public function reverify(ReverifyDTO $dto)
    {
        $user = User::where('email', $dto->email)->firstOrFail();
        $user->sendVerificationEmail();
    }
}
