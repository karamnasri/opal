<?php

namespace App\DTOs\Design;

use App\Traits\DtoRequestTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LikedDesignDTO
{
    use DtoRequestTrait;
    public Collection|LengthAwarePaginator $designs;
}
