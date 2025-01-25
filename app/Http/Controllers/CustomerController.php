<?php

namespace App\Http\Controllers;

use App\DTOs\Customer\CustomerDTO;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use ApiResponseTrait;

    public function __construct(public CustomerService $customerService) {}
    public function upsert(CustomerRequest $request)
    {
        $dto = CustomerDTO::fromRequest($request);
        $data = $this->customerService->upsertCustomer($dto);

        return $this->successResponse(new CustomerResource($data), 'Customer created successful');
    }
}
