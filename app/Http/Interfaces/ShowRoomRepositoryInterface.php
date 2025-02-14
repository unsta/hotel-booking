<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Http\Resources\ShowRoomResource;

interface ShowRoomRepositoryInterface
{
    public function getRoom(int $roomId): ShowRoomResource;
}
