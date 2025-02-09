<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Interfaces\ListBookingsRepositoryInterface;
use App\Http\Resources\ListBookingsResource;
use App\Models\Booking;

class ListBookingsRepository implements ListBookingsRepositoryInterface
{
    public function getBookings(): ListBookingsResource
    {
        return new ListBookingsResource(Booking::all());
    }
}
