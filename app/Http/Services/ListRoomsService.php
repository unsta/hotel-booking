<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\ListRoomsRepository;
use App\Http\Resources\ListRoomsResource;

readonly class ListRoomsService
{
    public function __construct(public ListRoomsRepository $repository)
    {
    }

    public function getRooms(): ListRoomsResource
    {
        return $this->repository->getRooms();
    }
}
