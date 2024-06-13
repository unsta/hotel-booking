<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Events\BookingCreated;
use App\Http\Exceptions\QueryException;
use App\Models\Booking;
use App\Models\Room;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

class StoreBookingRepository
{
    public function __construct()
    {
    }

    public function checkRoomAvailability(
        int $roomId,
        CarbonImmutable $checkInDate,
        CarbonImmutable $checkOurDate
    ): ?Booking {
        return Booking::select(['id', 'room_id', 'check_in_date', 'check_out_date'])
            ->where('room_id', $roomId)
            ->where(function (Builder $query) use ($checkInDate, $checkOurDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOurDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOurDate]);
            })
            ->first();
    }

    public function getRoom(int $roomId): Room
    {
        // @phpstan-ignore-next-line
        return Room::find($roomId);
    }

    /** @param array<mixed> $data */
    public function createBooking(array $data): Booking
    {
        $booking = Booking::create($data);

        if (! $booking instanceof Booking) {
            throw new QueryException(Booking::class);
        }

        BookingCreated::dispatch($booking);

        return $booking;
    }
}
