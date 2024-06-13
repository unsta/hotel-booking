<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Resources\ListRoomsResource;
use App\Models\Room;

class ListRoomsRepository
{
    public function __construct()
    {
    }

    public function getRooms(): ListRoomsResource
    {
        return new ListRoomsResource(Room::all());
    }
}
