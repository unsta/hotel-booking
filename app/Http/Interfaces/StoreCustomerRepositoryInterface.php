<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\Customer;

interface StoreCustomerRepositoryInterface
{
    /** @param array<string> $data */
    public function createCustomer(array $data): Customer;
}
