<?php

namespace Src\Products\Domain\Models\Post\Contracts;

use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice;

interface HasSecondaryPrice
{
    public function getSecondaryPrice(): CalculatedPrice;

    public function setSecondaryPrice(CalculatedPrice $secondaryPrice): void;
}
