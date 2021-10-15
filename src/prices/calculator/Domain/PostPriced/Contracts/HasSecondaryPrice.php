<?php

namespace Src\Prices\Calculator\Domain\PostPriced\Contracts;

use Src\Prices\Calculator\Domain\Price\Price;

interface HasSecondaryPrice
{
    public function secondaryPrice(): Price;
}
