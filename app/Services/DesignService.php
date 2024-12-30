<?php

namespace App\Services;

use App\DTOs\Design\DesignFilterDTO;
use App\Models\Design;

class DesignService
{
    public function getAll(DesignFilterDTO $dto)
    {
        $query = Design::query()->with(['category', 'likedByUsers']);

        if ($dto->category_id) {
            $query->where('category_id', $dto->category_id);
        }

        if ($dto->print_type) {
            $query->where('print_type', $dto->print_type);
        }

        if (!is_null($dto->is_free)) {
            if ($dto->is_free) {
                $query->whereNull('price');
            } else {
                $query->whereNotNull('price');
            }
        }

        if (!is_null($dto->is_liked)) {
            if ($dto->is_liked) {
                $query->whereHas('likedByUsers', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            }
        }

        $dto->designs = $query->paginate();
    }
}
