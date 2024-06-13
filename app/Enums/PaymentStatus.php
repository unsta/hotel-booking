<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatus: string
{
    case COMPLETE = "complete";
    case PENDING = "pending";
    case CANCELLED = "cancelled";
    case FAILED = "failed";
    case REFUNDED = "refunded";

    public static function values(): array
    {
        return [
            self::COMPLETE->value,
            self::PENDING->value,
            self::CANCELLED->value,
            self::FAILED->value,
            self::REFUNDED->value
        ];
    }
}
