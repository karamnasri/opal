<?php

namespace App\Services;

use App\DTOs\Customer\CustomerDTO;
use App\Models\Customer;

class CustomerService
{
    public function getCustomerByUserId($id)
    {
        return Customer::find($id);
    }

    public function upsertCustomer(CustomerDTO $dto)
    {
        $customer = $this->getCustomerByUserId(auth()->id());

        if ($customer) {
            $customer->update([
                'phone' => $dto->phone,
                'address' => $dto->address,
                'brand' => $dto->brand
            ]);
        } else {
            $customer = Customer::create([
                'phone' => $dto->phone,
                'address' => $dto->address,
                'brand' => $dto->brand,
                'user_id' => auth()->id()
            ]);
        }
        return $customer;
    }
}
