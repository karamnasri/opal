<?php

namespace App\DTOs;

use App\Models\Category;
use App\Traits\DtoRequestTrait;

class DesignDTO
{
    use DtoRequestTrait;

    public string $title;
    public string $description;
    public float $price;
    public float $discounted_price;
    public Category $category;
    public array $colors;
}
