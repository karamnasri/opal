<?php

namespace App\Services;

use App\DTOs\Design\DesignCategoryFilterDTO;
use App\Models\Design;

class DesignService
{
    public function getAll(DesignCategoryFilterDTO $dto)
    {
        $query = Design::query();

        if ($dto->category_id) {
            $query->where('category_id', $dto->category_id);
        }

        $dto->designs = $query->paginate();
    }
}
