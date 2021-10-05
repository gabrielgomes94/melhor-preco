<?php

namespace Src\Prices\Domain\Price\Commission;

use Barrigudinha\Utils\Helpers;
use Money\Money;

class MercadoLivre extends Commission
{
    private const MINIMUM_PRICE = 79;
    private const EXTRA_COMMISSION = 5;

    protected function fill(Money $price, float $commissionRate): void
    {
        $this->value = $price->multiply($commissionRate);

        if ($price->lessThan(Helpers::floatToMoney(self::MINIMUM_PRICE))) {
            $this->value = $this->value->add(Helpers::floatToMoney(self::EXTRA_COMMISSION));

            return;
        }
    }
}
