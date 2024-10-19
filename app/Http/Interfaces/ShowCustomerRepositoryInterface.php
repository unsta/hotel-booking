<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Http\Resources\ShowCustomerResource;

interface ShowCustomerRepositoryInterface
{
    public function getCustomer(int $customerId): ShowCustomerResource;
}
