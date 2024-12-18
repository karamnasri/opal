<?php

namespace App\Services\Auth;

use App\Contracts\Resettable;
use App\DTOs\Auth\ResetLinkDTO;
use App\DTOs\Auth\ResetPasswordDTO;
use App\Models\User;

class ResetService implements Resettable
{
    public function sendResetLink(ResetLinkDTO $dto)
    {
        $dto->user = User::where('email', $dto->email)->firstOrFail();
        $dto->token = $dto->user->createPasswordResetToken();
        $dto->user->sendResetPasswordEmail($dto);
    }

    public function validateResetLink(ResetLinkDTO $dto)
    {
        $dto->user = User::where('email', $dto->email)->firstOrFail();
        $dto->user->validResetToken($dto->token);
    }

    public function resetPassword(ResetPasswordDTO $dto)
    {
        $dto->user = User::where('email', $dto->email)->firstOrFail();
        $dto->user->validResetToken($dto->token);
        $dto->user->resetPassword($dto->password);
        $dto->user->deleteResetToken();
    }
}
