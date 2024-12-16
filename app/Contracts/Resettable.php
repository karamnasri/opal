<?php

namespace App\Contracts;

use App\DTOs\Auth\ResetLinkDTO;

interface Resettable
{
    public function sendResetLink(ResetLinkDTO $dto);
    public function resetPassword(string $token, string $email, string $newPassword);
}
