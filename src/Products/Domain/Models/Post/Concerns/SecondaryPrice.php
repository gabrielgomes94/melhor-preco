<?php

namespace Src\Products\Domain\Models\Post\Concerns;

use Src\Prices\Domain\Models\Calculator\Contracts\Price;

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
