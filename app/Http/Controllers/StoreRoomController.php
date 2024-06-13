<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Services\StoreRoomService;
use Illuminate\Http\JsonResponse;

readonly class StoreRoomController
{
    public function __construct(public StoreRoomService $service)
    {
    }

    public function __invoke(StoreRoomRequest $request): JsonResponse
    {
        $room = $this->service->createRoom(
            $request->number,
            $request->type,
            $request->price_per_night,
            $request->status
        );

        return response()->json([
            'status' => 'success',
            'message' => sprintf('Room [%s] was successfully created', $room->number)
        ]);
    }
}
