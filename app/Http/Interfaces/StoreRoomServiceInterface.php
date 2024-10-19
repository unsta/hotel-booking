<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\Room;

interface StoreRoomServiceInterface
{
    public function createRoom(
        string $number,
        string $type,
        int $pricePerNight,
        string $status
    ): Room;
}
