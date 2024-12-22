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
    public bool $verify = true;

    public function redirectUrl(): string
    {/*  */
        $frontendBase = config('path.frontend.base');
        $authPath = config('path.frontend.auth.google');

        if (!$frontendBase || !$authPath) {
            throw new \Exception('Frontend base path or auth path is not defined in configuration.');
        }

        return sprintf('%s%s?token=%s', rtrim($frontendBase, '/'), $authPath, $this->token);
    }
}
