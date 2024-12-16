<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Resettable;
use App\DTOs\Auth\ResetLinkDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendResetLinkRequest;

class PasswordResetController extends Controller
{
    public function __construct(private Resettable $resetService) {}

    public function sendResetLink(SendResetLinkRequest $request)
    {
        $dto = ResetLinkDTO::fromRequest($request);
        $this->resetService->sendResetLink($dto);
    }
}
