<?php

namespace Src\Products\Domain\Post\Concerns;

use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Price\Price;

trait SecondaryPrice
{
    private Price $secondaryPrice;

    public function getSecondaryPrice(): Price
    {
        return $this->secondaryPrice;
    }

//    public function getSecondaryProfit(): float
//    {
//        return MoneyTransformer::toFloat($this->secondaryPrice->getProfit());
//    }

    public function setSecondaryPrice(Price $secondaryPrice): void
    {
        $this->secondaryPrice = $secondaryPrice;
    }
}
