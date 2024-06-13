<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Services\StoreBookingService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;

readonly class StoreBookingController
{
    public function __construct(public StoreBookingService $service)
    {
    }

    public function __invoke(StoreBookingRequest $request): JsonResponse
    {
        $this->service->validateRoomAvailability(
            $request->room_id,
            new CarbonImmutable($request->check_in_date),
            new CarbonImmutable($request->check_out_date)
        );

        $booking = $this->service->createBooking(
            $request->room_id,
            $request->customer_id,
            new CarbonImmutable($request->check_in_date),
            new CarbonImmutable($request->check_out_date)
        );

        return response()->json([
            'status' => 'success',
            'message' => sprintf('Booking [%s] was successfully created', $booking->id)
        ]);
    }
}
