<?php

namespace Src\Products\Domain\Models\Post\Contracts;

use Src\Calculator\Domain\Models\Price\Price;

interface HasSecondaryPrice
{
    public function getSecondaryPrice(): Price;

//    public function getSecondaryProfit();

    public function setSecondaryPrice(Price $secondaryPrice): void;
}
