<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\{Booking, Room};
use Carbon\CarbonImmutable;

interface StoreBookingRepositoryInterface
{
    public function checkRoomAvailability(
        int $roomId,
        CarbonImmutable $checkInDate,
        CarbonImmutable $checkOurDate
    ): ?Booking;

    public function getRoom(int $roomId): Room;

    /** @param array<mixed> $data */
    public function createBooking(array $data): Booking;
}
