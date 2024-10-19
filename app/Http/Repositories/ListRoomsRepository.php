<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Interfaces\ListRoomsRepositoryInterface;
use App\Http\Resources\ListRoomsResource;
use App\Models\Room;

class ListRoomsRepository implements ListRoomsRepositoryInterface
{
    public function getRooms(): ListRoomsResource
    {
        return new ListRoomsResource(Room::all());
    }
}
