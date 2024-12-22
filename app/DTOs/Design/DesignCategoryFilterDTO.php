<?php

namespace App\DTOs\Design;

use App\Traits\DtoRequestTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DesignCategoryFilterDTO
{
    use DtoRequestTrait;
    public ?int $category_id = null;
    public Collection|LengthAwarePaginator $designs;
}
