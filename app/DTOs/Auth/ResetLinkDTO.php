<?php

namespace App\DTOs\Auth;

use App\Models\User;
use App\Traits\DtoRequestTrait;

class ResetLinkDTO
{
    use DtoRequestTrait;
    public string $email;
    public string $token;
    public User $user;
    public function url()
    {
        return url(config('path.auth') . '/password/reset?token=' . $this->token . '&email=' . urlencode($this->email));
    }
}
