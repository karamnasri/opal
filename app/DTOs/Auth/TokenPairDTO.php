<?php

namespace App\DTOs\Auth;

use App\Traits\DtoRequestTrait;

class TokenPairDTO
{
    use DtoRequestTrait;
    public string $accessToken;
    public string $refreshToken;

    public function __construct(
        string $accessToken,
        string $refreshToken
    ) {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }
}
