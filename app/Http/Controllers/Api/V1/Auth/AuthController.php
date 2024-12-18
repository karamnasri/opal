<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Authenticatable;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private Authenticatable $authService) {}

    public function register(RegisterRequest $request)
    {
        $dto = RegisterDTO::fromRequest($request);
        $this->authService->register($dto);

        return $this->successResponse(new RegisterResource($dto), 'Registration successful');
    }

    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromRequest($request);
        $this->authService->login($dto);

        return $this->successResponse(new LoginResource($dto), 'Login successful');
    }

    public function logout()
    {
        $this->authService->logout();

        return $this->successResponse([], 'Logout successfully');
    }
}
