<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Sociable;
use App\Http\Controllers\Controller;
use App\Http\Resources\GoogleAuthResource;
use App\Traits\ApiResponseTrait;


class SocialAuthController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private Sociable $socialAuthService) {}

    public function redirect(string $provider)
    {
        $url = $this->socialAuthService->redirectToProvider($provider);
        return $this->successResponse(new GoogleAuthResource(['url' => $url]), 'Redirect to Google successful');
    }

    public function handleCallback(string $provider)
    {
        $socialUser = $this->socialAuthService->handleProviderCallback($provider);
        $token = $this->socialAuthService->loginOrRegister($socialUser, $provider);

        return $this->successResponse(new GoogleAuthResource(['token' => $token]), 'Login with Google successful');
    }
}
