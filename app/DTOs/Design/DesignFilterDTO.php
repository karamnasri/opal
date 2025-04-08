<?php

namespace App\DTOs\Design;

use App\Traits\DtoRequestTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DesignFilterDTO
{
    use DtoRequestTrait;
    public ?int $category_id = null;
    public ?string $print_type = null;
    public ?string $query = null;
    public ?bool $is_free = null;
    public ?bool $is_liked = null;
    public Collection|LengthAwarePaginator $designs;

    public function hasCategoryFilter(): bool
    {
        return !empty($this->category_id);
    }

    public function hasPrintTypeFilter(): bool
    {
        return !empty($this->print_type);
    }

    public function hasSearchFilter(): bool
    {
        return !empty($this->query);
    }

    public function hasFreeFilter(): bool
    {
        return (bool) $this->is_free;
    }

    public function hasLikedFilter(): bool
    {
        return (bool) $this->is_liked;
    }
}
