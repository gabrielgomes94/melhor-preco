<?php

namespace Src\Products\Domain\Models\Post\Concerns;

use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Models\Price\Price;

trait SecondaryPrice
{
    private Price $secondaryPrice;

    public function getSecondaryPrice(): Price
    {
        return $this->secondaryPrice;
    }

    public function setSecondaryPrice(Price $secondaryPrice): void
    {
        $this->secondaryPrice = $secondaryPrice;
    }
}
