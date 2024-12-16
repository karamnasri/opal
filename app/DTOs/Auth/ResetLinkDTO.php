<?php

namespace App\DTOs\Auth;

use App\Traits\DtoRequestTrait;

class ResetLinkDTO
{
    use DtoRequestTrait;
    public string $email;
    public string $token;
    public function url()
    {
        return url('/password/reset?token=' . $this->token . '&email=' . urlencode($this->email));
    }
}
