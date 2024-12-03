<?php

namespace App\Contracts;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;

interface Authenticatable
{
    public function register(RegisterDTO $dto);
    public function login(LoginDTO $dto);
    public function logout();
}
