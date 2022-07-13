<?php

namespace Src\Calculator\Domain\Services\Contracts;

use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as PriceCalculated;
use Src\Prices\Infrastructure\Laravel\Models\Price;

interface CalculatePost
{
    public function calculatePost(Price $price, array $options = []): PriceCalculated;
}
