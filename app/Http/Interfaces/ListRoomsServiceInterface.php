<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Http\Resources\ListRoomsResource;

interface ListRoomsServiceInterface
{
    public function getRooms(): ListRoomsResource;
}
