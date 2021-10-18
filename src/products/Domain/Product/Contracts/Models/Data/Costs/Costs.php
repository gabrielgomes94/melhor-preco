<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Costs;

interface Costs
{
    public function additionalCosts(): float;

    public function purchasePrice(): float;

    public function taxICMS(): float;
}
