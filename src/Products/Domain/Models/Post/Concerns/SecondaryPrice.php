<?php

namespace Src\Products\Domain\Models\Post\Concerns;

use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Price;

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
