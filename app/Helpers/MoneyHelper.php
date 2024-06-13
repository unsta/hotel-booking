<?php

declare(strict_types=1);

namespace App\Helpers;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class MoneyHelper
{
    public static function formatDecimal(Money $money): string
    {
        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money);
    }
}
