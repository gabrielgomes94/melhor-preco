<?php

namespace Src\Products\Domain\Models\Post\Contracts;

use Src\Calculator\Domain\Models\Price\Contracts\Price;

interface HasSecondaryPrice
{
    public function getSecondaryPrice(): Price;

    public function setSecondaryPrice(Price $secondaryPrice): void;
}
