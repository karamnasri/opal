<?php

namespace App\Contracts;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\ReverifyDTO;
use App\DTOs\Auth\VerifyDTO;

interface AuthServiceInterface
{
    public function register(RegisterDTO $dto);
    public function login(LoginDTO $dto);
    public function verify(VerifyDTO $dto);
    public function reverify(ReverifyDTO $dto);
}
