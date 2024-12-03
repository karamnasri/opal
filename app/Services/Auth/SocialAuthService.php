<?php

namespace App\Services\Auth;

use App\Contracts\Sociable;
use App\DTOs\Auth\SocialCallbackDTO;
use App\DTOs\Auth\SocialRedirectDTO;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthService implements Sociable
{
    public function redirectToProvider(SocialRedirectDTO $dto): SocialRedirectDTO
    {
        $dto->url = Socialite::driver($dto->provider)->stateless()->redirect()->getTargetUrl();
        return $dto;
    }

    public function handleProviderCallback(SocialCallbackDTO $dto): SocialCallbackDTO
    {
        $dto->socialUser = Socialite::driver($dto->provider)->stateless()->user();
        return $dto;
    }

    public function loginOrRegister(SocialCallbackDTO $dto): SocialCallbackDTO
    {
        $dto->user = User::findOrCreateFromSocialUser($dto->socialUser, $dto->provider);
        $dto->token = $dto->user->token();
        return $dto;
    }

    public function logout()
    {
        Auth::user()?->currentAccessToken()->delete();
    }
}
