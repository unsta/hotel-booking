<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\Room;

interface StoreRoomRepositoryInterface
{
    /** @param array<string, int|string> $data */
    public function createRoom(array $data): Room;
}
