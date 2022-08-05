<?php

namespace Src\Prices\Domain\DataTransfer;

use Src\Marketplaces\Domain\Models\Marketplace;

class ListPricesCalculated
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly array $calculatedPrices
    )
    {
    }
}
