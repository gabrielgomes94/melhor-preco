<?php

namespace Src\Calculator\Domain\Services\Contracts;

use Src\Calculator\Domain\Models\Price\Price as PriceCalculated;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Product\Product;

interface CalculatePost
{
    public function calculatePost(Price $price, array $options = []): PriceCalculated;
}
