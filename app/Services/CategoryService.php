<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{

    public function getAll()
    {
        return Cache::remember('categories', now()->addDay(), function () {
            return Category::all();
        });
    }
}
