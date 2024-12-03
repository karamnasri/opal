<?php

namespace App\DTOs\Auth;

use App\Models\User;
use App\Traits\DtoRequestTrait;
use Laravel\Socialite\Contracts\User as SocialUser;

class SocialCallbackDTO
{
    use DtoRequestTrait;
    public string $provider;
    public SocialUser $socialUser;
    public User $user;
    public string $token;
}
