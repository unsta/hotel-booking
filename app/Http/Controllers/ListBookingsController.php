<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ListBookingsResource;
use App\Http\Services\ListBookingsService;

readonly class ListBookingsController
{
    public function __construct(public ListBookingsService $service)
    {
    }

    public function __invoke(): ListBookingsResource
    {
        return $this->service->getBookings();
    }
}
