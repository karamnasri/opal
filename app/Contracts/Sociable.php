<?php

namespace App\Contracts;

use Laravel\Socialite\Contracts\User as SocialUser;

interface Sociable
{
    public function redirectToProvider(string $provider): string;
    public function handleProviderCallback(string $provider): SocialUser;
    public function loginOrRegister(SocialUser $socialUser, string $provider);
    public function logout();
}
