<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Verifiable;
use App\DTOs\Auth\VerifyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyRequest;
use App\Traits\ApiResponseTrait;

class VerifyController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private Verifiable $verifyService) {}
    public function verify(VerifyRequest $request)
    {
        $dto = VerifyDTO::fromRequest($request);
        $this->verifyService->verify($dto);

        return $this->successResponse([], 'Email Verify successfully');
    }

    public function reverify()
    {
        $this->verifyService->reverify();

        return $this->successResponse([], 'Verification re-sent successfully');
    }
}
