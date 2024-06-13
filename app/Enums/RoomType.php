<?php

declare(strict_types=1);

namespace App\Enums;

enum RoomType: string
{
    case SINGLE_ROOM = "single room";
    case DOUBLE_ROOM = "double room";
    case TRIPLE_ROOM = "triple room";
    case QUEEN_ROOM = "queen room";
    case KING_ROOM = "king room";
    case SUITE = "suite";

    public static function values(): array
    {
        return [
            self::SINGLE_ROOM->value,
            self::DOUBLE_ROOM->value,
            self::TRIPLE_ROOM->value,
            self::QUEEN_ROOM->value,
            self::KING_ROOM->value,
            self::SUITE->value,
        ];
    }
}
