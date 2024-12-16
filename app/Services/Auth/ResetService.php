<?php

namespace App\Services\Auth;

use App\Contracts\Resettable;
use App\DTOs\Auth\ResetLinkDTO;
use App\Jobs\SendPasswordResetLinkJob;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ResetService implements Resettable
{
    public function sendResetLink(ResetLinkDTO $dto)
    {
        $user = User::where('email', $dto->email)->firstOrFail();
        $dto->token = $user->createPasswordResetToken();
        $user->sendResetPasswordEmail($dto);
    }


    public function resetPassword(string $token, string $email, string $newPassword) {}
    private function validateResetToken(string $token, string $email): bool {}
}
