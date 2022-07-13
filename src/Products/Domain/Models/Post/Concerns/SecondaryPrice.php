<?php

namespace Src\Products\Domain\Models\Post\Concerns;

use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice;

trait SecondaryPrice
{
    private CalculatedPrice $secondaryPrice;

    public function getSecondaryPrice(): CalculatedPrice
    {
        return $this->secondaryPrice;
    }

    public function setSecondaryPrice(CalculatedPrice $secondaryPrice): void
    {
        $this->secondaryPrice = $secondaryPrice;
    }
}
