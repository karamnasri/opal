<?php

namespace App\Services\Auth;

use App\Contracts\Sociable;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthService implements Sociable
{
    public function redirectToProvider(string $provider): string
    {
        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    }

    public function handleProviderCallback(string $provider): SocialUser
    {
        return Socialite::driver($provider)->stateless()->user();
    }

    public function loginOrRegister(SocialUser $socialUser, string $provider)
    {
        $user = User::findOrCreateFromSocialUser($socialUser, $provider);
        return $user->token();
    }

    public function logout()
    {
        Auth::user()?->currentAccessToken()->delete();
    }
}
