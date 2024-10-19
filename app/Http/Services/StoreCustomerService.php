<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Interfaces\StoreCustomerServiceInterface;
use App\Http\Repositories\StoreCustomerRepository;
use App\Models\Customer;

readonly class StoreCustomerService implements StoreCustomerServiceInterface
{
    public function __construct(public StoreCustomerRepository $repository)
    {
    }

    public function createCustomer(string $name, string $email, string $phoneNumber): Customer
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phoneNumber
        ];

        return $this->repository->createCustomer($data);
    }
}
