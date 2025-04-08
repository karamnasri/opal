<?php

namespace App\DTOs\Auth;


use App\Traits\DtoRequestTrait;


class RefreshDTO
{
    use DtoRequestTrait;

    public TokenPairDTO $tokens;
}
