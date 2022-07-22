<?php

namespace Src\Prices\Domain\DataTransfer;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice;
use Src\Products\Domain\Models\Product\Product;

class PriceCalculatedFromProduct
{
    public function __construct(
        public readonly Product $product,
        public readonly Marketplace $marketplace,
        public readonly CalculatedPrice $calculatedPrice
    )
    {}
}
