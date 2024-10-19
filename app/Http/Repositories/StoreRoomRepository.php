<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Exceptions\QueryException;
use App\Http\Interfaces\StoreRoomRepositoryInterface;
use App\Models\Room;

class StoreRoomRepository implements StoreRoomRepositoryInterface
{
    /** @param array<string, int|string> $data */
    public function createRoom(array $data): Room
    {
        $room = Room::create($data);

        if (! $room instanceof Room) {
            throw new QueryException(Room::class);
        }

        return $room;
    }
}
