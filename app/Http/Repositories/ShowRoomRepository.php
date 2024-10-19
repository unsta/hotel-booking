<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Exceptions\EntityNotFoundException;
use App\Http\Interfaces\ShowRoomRepositoryInterface;
use App\Http\Resources\ShowRoomResource;
use App\Models\Room;

class ShowRoomRepository implements ShowRoomRepositoryInterface
{
    public function getRoom(int $roomId): ShowRoomResource
    {
        $room = Room::find($roomId);

        if (null === $room) {
            throw new EntityNotFoundException(Room::class);
        }

        return new ShowRoomResource($room);
    }
}
