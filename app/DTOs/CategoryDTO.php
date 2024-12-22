<?php

namespace App\DTOs;

use App\Traits\DtoRequestTrait;

class CategoryDTO
{
    use DtoRequestTrait;
    public string $name;
    public string $description;
}
