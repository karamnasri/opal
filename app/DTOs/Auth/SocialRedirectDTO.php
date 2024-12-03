<?php

namespace App\DTOs\Auth;

use App\Traits\DtoRequestTrait;

class SocialRedirectDTO
{
    use DtoRequestTrait;
    public string $provider;
    public string $url;
}
