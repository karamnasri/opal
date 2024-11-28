<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\AuthServiceInterface;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\ReverifyDTO;
use App\DTOs\Auth\VerifyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ReverifyRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AuthServiceInterface $authService) {}

    public function register(RegisterRequest $request)
    {
        $dto = RegisterDTO::fromRequest($request);
        $user = $this->authService->register($dto);
        return $this->successResponse(new RegisterResource($user), 'Registration successful');
    }

    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromRequest($request);
        $data = $this->authService->login($dto);

        return $this->successResponse(new LoginResource($data), 'Login successful');
    }

    public function verify(VerifyRequest $request)
    {
        $dto = VerifyDTO::fromRequest($request);
        $this->authService->verify($dto);

        return $this->successResponse([], 'Email Verify successfully');
    }

    public function reverify(ReverifyRequest $request)
    {
        $dto = ReverifyDTO::fromRequest($request);
        $this->authService->reverify($dto);

        return $this->successResponse([], 'Verification re-sent successfully');
    }
}
