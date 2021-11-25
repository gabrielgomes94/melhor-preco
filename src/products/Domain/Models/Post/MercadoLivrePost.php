<?php

namespace Src\Products\Domain\Models\Post;

use Money\Money;
use Src\Products\Domain\Models\Post\Concerns\SecondaryPrice;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;

class MercadoLivrePost extends Post implements HasSecondaryPrice
{
    use SecondaryPrice;

    public function isProfitable(): bool
    {
        $mainProfit = $this->price->getProfit();
        $secondaryProfit = $this->secondaryPrice->getProfit();

        if ($mainProfit->lessThan($secondaryProfit)) {
            return $secondaryProfit->greaterThanOrEqual(Money::BRL(0));
        }

        return $mainProfit->greaterThanOrEqual(Money::BRL(0));
    }
}
