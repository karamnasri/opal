<?php

namespace App\DTOs\Customer;

use App\Traits\DtoRequestTrait;

class CustomerDTO
{
    use DtoRequestTrait;
    public string $phone;
    public ?string $address = null;
    public ?string $brand = null;
}
