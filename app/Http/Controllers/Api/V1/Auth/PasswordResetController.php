<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Resettable;
use App\DTOs\Auth\ResetLinkDTO;
use App\DTOs\Auth\ResetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\SendResetLinkRequest;
use App\Http\Requests\Auth\validateResetTokenRequest;
use App\Http\Resources\ValidateResetTokenResource;
use App\Traits\ApiResponseTrait;

class PasswordResetController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private Resettable $resetService) {}

    public function sendResetLink(SendResetLinkRequest $request)
    {
        $dto = ResetLinkDTO::fromRequest($request);
        $this->resetService->sendResetLink($dto);

        return $this->successResponse([], 'Reset password link sent successfully');
    }

    public function validateResetToken(validateResetTokenRequest $request)
    {
        $dto = ResetLinkDTO::fromRequest($request);
        $this->resetService->validateResetLink($dto);

        return $this->successResponse(new ValidateResetTokenResource($dto), 'Reset password link is valid');
    }

    public function resetPassword(PasswordResetRequest $request)
    {
        $dto = ResetPasswordDTO::fromRequest($request);
        $this->resetService->resetPassword($dto);

        return $this->successResponse([], 'Password reset successfully.');
    }
}
