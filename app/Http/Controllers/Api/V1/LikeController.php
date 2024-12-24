<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\LikeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Design;
use App\Services\LikeService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private LikeService $likeService) {}
    public function toggle(LikeRequest $request)
    {
        $dto = LikeDTO::fromRequest($request);
        $this->likeService->toggle($dto);

        return $this->successResponse(new LikeResource($dto), $dto->message);
    }
}
