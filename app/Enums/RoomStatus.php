<?php

declare(strict_types=1);

namespace App\Enums;

enum RoomStatus: string
{
    case OCCUPIED = "occupied";
    case VACANT = "vacant";

    public static function values(): array
    {
        return [self::OCCUPIED->value, self::VACANT->value];
    }
}
