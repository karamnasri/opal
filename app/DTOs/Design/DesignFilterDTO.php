<?php

namespace App\DTOs\Design;

use App\Enums\PrintTypeEnum;
use App\Traits\DtoRequestTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DesignFilterDTO
{
    use DtoRequestTrait;
    public ?int $category_id = null;
    public ?string $print_type = null;
    public ?bool $is_free = null;
    public Collection|LengthAwarePaginator $designs;
}
