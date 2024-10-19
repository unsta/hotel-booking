<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Exceptions\RoomAvailabilityException;
use App\Http\Interfaces\StoreBookingServiceInterface;
use App\Http\Repositories\StoreBookingRepository;
use App\Models\Booking;
use Carbon\CarbonImmutable;
use Money\Money;

readonly class StoreBookingService implements StoreBookingServiceInterface
{
    public function __construct(public StoreBookingRepository $repository)
    {
    }

    public function validateRoomAvailability(
        int $roomId,
        CarbonImmutable $checkInDate,
        CarbonImmutable $checkOutDate
    ): void {
        $booking = $this->repository->checkRoomAvailability($roomId, $checkInDate, $checkOutDate);

        if (null !== $booking) {
            throw new RoomAvailabilityException();
        }
    }

    public function createBooking(
        int $roomId,
        int $customerId,
        CarbonImmutable $checkInDate,
        CarbonImmutable $checkOutDate
    ): Booking {
        $nightsDays = (int) $checkInDate->diffInDays($checkOutDate);

        $data = [
            'room_id' => $roomId,
            'customer_id' => $customerId,
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'total_price' => $this->calculateTotalPrice($roomId, $nightsDays),
        ];

        return $this->repository->createBooking($data);
    }

    public function calculateTotalPrice(int $roomId, int $nightsDays): int
    {
        $room = $this->repository->getRoom($roomId);

        return (int) (Money::EUR($room->price_per_night)->multiply($nightsDays))->getAmount();
    }
}
