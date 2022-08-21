<?php

namespace Src\Prices\Domain\DataTransfer;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price as PriceModel;
use Src\Products\Domain\Models\Product;

class PriceCalculatedFromProduct
{
    public function __construct(
        public readonly Product $product,
        public readonly Marketplace $marketplace,
        public readonly CalculatedPrice $calculatedPrice
    )
    {}

    public static function fromPrice(PriceModel $price, CalculatedPrice $calculatedPrice): self
    {
        return new self(
            $price->getProduct(),
            $price->getMarketplace(),
            $calculatedPrice
        );
    }
}
