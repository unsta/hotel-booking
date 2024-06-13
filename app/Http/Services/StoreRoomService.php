<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\StoreRoomRepository;
use App\Models\Room;

readonly class StoreRoomService
{
    public function __construct(public StoreRoomRepository $repository)
    {
    }

    public function createRoom(
        string $number,
        string $type,
        int $pricePerNight,
        string $status
    ): Room {
        $data = [
            'number' => $number,
            'type' => $type,
            'price_per_night' => $pricePerNight,
            'status' => $status,
        ];

        return $this->repository->createRoom($data);
    }
}
