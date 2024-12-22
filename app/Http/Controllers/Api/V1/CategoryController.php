<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private CategoryService $categoryService) {}
    public function index()
    {
        $data = $this->categoryService->getAll();

        return $this->successResponse(CategoryResource::collection($data), 'Categories retrieved successfully.');
    }
}
