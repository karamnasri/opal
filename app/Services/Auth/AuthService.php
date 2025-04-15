<?php

namespace App\Services\Auth;

use App\Contracts\Authenticatable;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RefreshDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\TokenPairDTO;
use App\DTOs\Auth\UserDTO;
use App\Enums\TokenAbilityEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService implements Authenticatable
{
    public function register(RegisterDTO $dto)
    {
        $user = User::createUser($dto->toArray());
        $user->sendVerificationEmail();
        $dto->tokens = $user->token();
    }

    public function login(LoginDTO $dto)
    {
        Auth::attempt($dto->credentials());
        $user = Auth::user();
        $dto->verify = (bool) $user->email_verified_at;
        $dto->tokens =  $user->token();
    }

    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            // Optionally: Revoke all user tokens (logout from all devices)
            $user->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json(['message' => 'Logged out from all devices.']);
        }

        return response()->json(['message' => 'No user found.'], 401);
    }

    public function refresh(RefreshDTO $dto)
    {
        $user = Auth::user();

        $user->tokens()->where('name', 'refresh-token')->delete();
        $user->tokens()->where('name', 'access-token')->delete();

        $dto->tokens = $user->token();
    }

    public function getUser(UserDTO $dto)
    {
        $dto->user = Auth::user();
    }
}
