<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Http\Resources\ListBookingsResource;

interface ListBookingsRepositoryInterface
{
    public function getBookings(): ListBookingsResource;
}
