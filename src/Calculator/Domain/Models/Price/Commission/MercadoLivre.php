<?php

namespace Src\Calculator\Domain\Models\Price\Commission;

use Money\Money;
use Src\Math\MoneyTransformer;

class MercadoLivre extends Commission
{
    private const MINIMUM_PRICE = 79;
    private const EXTRA_COMMISSION = 5;

    protected function fill(Money $price, float $commissionRate): void
    {
        $this->value = $price->multiply($commissionRate);

        if ($price->lessThan(MoneyTransformer::toMoney(self::MINIMUM_PRICE))) {
            $this->value = $this->value->add(MoneyTransformer::toMoney(self::EXTRA_COMMISSION));

            return;
        }
    }
}
