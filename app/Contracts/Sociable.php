<?php

namespace App\Contracts;

use App\DTOs\Auth\SocialCallbackDTO;
use App\DTOs\Auth\SocialRedirectDTO;

interface Sociable
{
    public function redirectToProvider(SocialRedirectDTO $dto): SocialRedirectDTO;
    public function handleProviderCallback(SocialCallbackDTO $dto): SocialCallbackDTO;
    public function loginOrRegister(SocialCallbackDTO $dto): SocialCallbackDTO;
    public function logout();
}
