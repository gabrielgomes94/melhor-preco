<?php

namespace Src\Calculator\Domain\Services\Contracts;

use Src\Calculator\Domain\Models\Price\Contracts\Price as PriceCalculated;
use Src\Prices\Infrastructure\Laravel\Models\Price;

interface CalculatePost
{
    public function calculatePost(Price $price, array $options = []): PriceCalculated;
}
