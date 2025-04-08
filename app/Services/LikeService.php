<?php

namespace App\Services;

use App\DTOs\LikeDTO;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function toggle(LikeDTO $dto)
    {
        $dto->fillDTO()->toggle();
    }
}
