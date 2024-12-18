<?php

namespace App\Contracts;

use App\DTOs\Auth\ResetLinkDTO;
use App\DTOs\Auth\ResetPasswordDTO;

interface Resettable
{
    public function sendResetLink(ResetLinkDTO $dto);
    public  function validateResetLink(ResetLinkDTO $dto);
    public function resetPassword(ResetPasswordDTO $dto);
}
