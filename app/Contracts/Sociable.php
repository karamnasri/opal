<?php

namespace App\Contracts;

use App\DTOs\Auth\SocialCallbackDTO;
use App\DTOs\Auth\SocialRedirectDTO;

interface Sociable
{
    public function redirectToProvider(SocialRedirectDTO $dto);
    public function handleProviderCallback(SocialCallbackDTO $dto);
    public function loginOrRegister(SocialCallbackDTO $dto);
    public function logout();
}
