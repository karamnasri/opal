<?php

namespace App\Contracts;

use App\DTOs\Auth\ReverifyDTO;
use App\DTOs\Auth\VerifyDTO;

interface Verifiable
{
    public function verify(VerifyDTO $dto);
    public function reverify();
}
