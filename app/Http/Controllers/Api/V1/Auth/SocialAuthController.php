<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Sociable;
use App\DTOs\Auth\SocialCallbackDTO;
use App\DTOs\Auth\SocialRedirectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocialProviderRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\SocialRedirectResource;
use App\Traits\ApiResponseTrait;


class SocialAuthController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private Sociable $socialAuthService) {}

    public function redirect(SocialProviderRequest $request)
    {
        $dto = SocialRedirectDTO::fromRequest($request);
        $this->socialAuthService->redirectToProvider($dto);

        return $this->successResponse(new SocialRedirectResource($dto), 'Redirect to Google successful');
    }

    public function handleCallback(SocialProviderRequest $request)
    {
        $dto = SocialCallbackDTO::fromRequest($request);
        $this->socialAuthService->handleProviderCallback($dto);
        $this->socialAuthService->loginOrRegister($dto);

        return $this->successResponse(new LoginResource($dto), 'Login with Google successful');
    }
}
