<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\PurchaseDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseResource;
use App\Models\Design;
use App\Services\PurchaseService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private PurchaseService $purchaseService) {}
    public function index()
    {
        $dto = new PurchaseDTO();
        $this->purchaseService->getUserPurchases($dto);

        return $this->successResponse(PurchaseResource::collection($dto->purchases), 'Purchases retrieved successfully.');
    }

    public function download(Design $design)
    {
        $user = Auth::user();

        if (!$user || !$design->isRecentlyPurchasedBy($user)) {
            abort(Response::HTTP_FORBIDDEN, 'You are not allowed to download this file.');
        }

        $filePath = storage_path('app/' . $design->file_path);

        if (!file_exists($filePath)) {
            abort(Response::HTTP_NOT_FOUND, 'File not found.');
        }

        return response()->download($filePath);
    }
}
