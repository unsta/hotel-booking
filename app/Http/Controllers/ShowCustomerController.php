<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ShowCustomerResource;
use App\Http\Services\ShowCustomerService;

readonly class ShowCustomerController
{
    public function __construct(public ShowCustomerService $service)
    {
    }

    public function __invoke(int $customerId): ShowCustomerResource
    {
        return $this->service->getCustomer($customerId);
    }
}
