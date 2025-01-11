<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannerResource;
use App\Services\BannerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private BannerService $bannerService) {}
    public function index()
    {
        $data = $this->bannerService->getAll();

        return $this->successResponse(BannerResource::collection($data), 'Banners retrieved successfully.');
    }
}
