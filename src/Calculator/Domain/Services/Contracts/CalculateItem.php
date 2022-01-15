<?php

namespace Src\Calculator\Domain\Services\Contracts;

use Src\Sales\Domain\Models\Item;

interface CalculateItem extends CalculatorOptions
{
    public function calculate(Item $item);
}
