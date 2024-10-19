<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\Customer;

interface StoreCustomerServiceInterface
{
    public function createCustomer(string $name, string $email, string $phoneNumber): Customer;
}
