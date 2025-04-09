<?php

namespace App\DTOs\Auth;

use App\Models\User;
use App\Traits\DtoRequestTrait;

class UserDTO
{
    use DtoRequestTrait;
    public User $user;
}
