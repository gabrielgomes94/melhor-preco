<?php

namespace Src\Sales\Domain\Services;

use Src\Sales\Infrastructure\Laravel\Models\Item;

interface CalculateItem
{
    public function calculate(Item $item);
}
