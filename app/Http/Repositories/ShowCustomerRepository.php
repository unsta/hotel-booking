<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Exceptions\EntityNotFoundException;
use App\Http\Resources\ShowCustomerResource;
use App\Models\Customer;

class ShowCustomerRepository
{
    public function getCustomer(int $customerId): ShowCustomerResource
    {
        $customer = Customer::find($customerId);

        if (null === $customer) {
            throw new EntityNotFoundException(Customer::class);
        }

        return new ShowCustomerResource($customer);
    }
}
