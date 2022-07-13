<?php

namespace Src\Products\Domain\Models\Post\Contracts;

use Src\Prices\Domain\Models\Calculator\Contracts\Price;

interface HasSecondaryPrice
{
    public function getSecondaryPrice(): Price;

    public function setSecondaryPrice(Price $secondaryPrice): void;
}
