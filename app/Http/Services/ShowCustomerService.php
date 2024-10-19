<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Interfaces\ShowCustomerServiceInterface;
use App\Http\Repositories\ShowCustomerRepository;
use App\Http\Resources\ShowCustomerResource;

readonly class ShowCustomerService implements ShowCustomerServiceInterface
{
    public function __construct(public ShowCustomerRepository $repository)
    {
    }

    public function getCustomer(int $customerId): ShowCustomerResource
    {
        return $this->repository->getCustomer($customerId);
    }
}
