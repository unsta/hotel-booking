<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\Booking;
use Carbon\CarbonImmutable;

interface StoreBookingServiceInterface
{
    public function validateRoomAvailability(
        int $roomId,
        CarbonImmutable $checkInDate,
        CarbonImmutable $checkOutDate
    ): void;

    public function createBooking(
        int $roomId,
        int $customerId,
        CarbonImmutable $checkInDate,
        CarbonImmutable $checkOutDate
    ): Booking;

    public function calculateTotalPrice(int $roomId, int $nightsDays): int;
}
