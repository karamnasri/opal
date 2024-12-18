<?php

namespace App\Services\Auth;

use App\Contracts\Sociable;
use App\DTOs\Auth\SocialCallbackDTO;
use App\DTOs\Auth\SocialRedirectDTO;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthService implements Sociable
{
    public function redirectToProvider(SocialRedirectDTO $dto)
    {
        $dto->url = Socialite::driver($dto->provider)->stateless()->redirect()->getTargetUrl();
    }

    public function handleProviderCallback(SocialCallbackDTO $dto)
    {
        $dto->socialUser = Socialite::driver($dto->provider)->stateless()->user();
    }

    public function loginOrRegister(SocialCallbackDTO $dto)
    {
        $dto->user = User::findOrCreateFromSocialUser($dto->socialUser, $dto->provider);
        $dto->token = $dto->user->token();
    }

    public function logout()
    {
        Auth::user()?->currentAccessToken()->delete();
    }
}
