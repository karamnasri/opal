<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Authenticatable;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RefreshDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthTokenResource;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private Authenticatable $authService) {}

    public function register(RegisterRequest $request)
    {
        $dto = RegisterDTO::fromRequest($request);
        $this->authService->register($dto);

        return $this->successResponse(new AuthTokenResource($dto), 'Registration successful');
    }

    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromRequest($request);
        $this->authService->login($dto);

        return $this->successResponse(new AuthTokenResource($dto), 'Login successful');
    }

    public function logout()
    {
        $this->authService->logout();

        return $this->successResponse([], 'Logout successfully');
    }

    public function refresh()
    {
        $dto = new RefreshDTO();
        $this->authService->refresh($dto);
        return $this->successResponse(new TokenResource($dto), 'Refreshed successful');
    }

    public function user()
    {
        $dto = new UserDTO();
        $this->authService->getUser($dto);
        return $this->successResponse(new UserResource($dto), 'User data retrieve successful');
    }
}
