<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Exceptions\QueryException;
use App\Models\Customer;

class StoreCustomerRepository
{
    public function __construct()
    {
    }

    /** @param array<string> $data */
    public function createCustomer(array $data): Customer
    {
        $customer = Customer::create($data);

        if (! $customer instanceof Customer) {
            throw new QueryException(Customer::class);
        }

        return $customer;
    }
}
