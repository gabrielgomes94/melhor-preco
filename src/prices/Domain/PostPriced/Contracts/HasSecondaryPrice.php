<?php

namespace Src\Prices\Domain\PostPriced\Contracts;

use Src\Prices\Domain\Price\Price;

interface HasSecondaryPrice
{
    public function secondaryPrice(): Price;
}
