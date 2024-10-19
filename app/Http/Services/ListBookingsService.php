<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Interfaces\ListBookingsServiceInterface;
use App\Http\Repositories\ListBookingsRepository;
use App\Http\Resources\ListBookingsResource;

readonly class ListBookingsService implements ListBookingsServiceInterface
{
    public function __construct(public ListBookingsRepository $repository)
    {
    }

    public function getBookings(): ListBookingsResource
    {
        return $this->repository->getBookings();
    }
}
