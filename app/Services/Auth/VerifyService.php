<?php

namespace App\Services\Auth;

use App\Contracts\Verifiable;
use App\DTOs\Auth\VerifyDTO;
use App\Models\User;

class VerifyService implements Verifiable
{
    public function verify(VerifyDTO $dto)
    {
        $user  = User::find(auth()->user()->id);
        $user->verifyCodeAndExpiration($dto->verification_code);
        $user->markEmailAsVerified();
    }

    public function reverify(): void
    {
        $user  = User::find(auth()->user()->id);
        $user->sendVerificationEmail();
    }
}
