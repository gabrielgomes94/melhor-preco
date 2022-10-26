<?php

namespace Src\Sales\Domain\Services;

use Src\Sales\Application\Models\Item;

interface CalculateItem
{
    public function calculate(Item $item);
}
