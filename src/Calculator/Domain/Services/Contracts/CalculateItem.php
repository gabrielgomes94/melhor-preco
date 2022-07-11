<?php

namespace Src\Calculator\Domain\Services\Contracts;

use Src\Sales\Infrastructure\Laravel\Models\Item;

interface CalculateItem extends CalculatorOptions
{
    public function calculate(Item $item);
}
