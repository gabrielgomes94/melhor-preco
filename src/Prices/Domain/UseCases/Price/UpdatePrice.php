<?php

namespace Src\Prices\Domain\UseCases\Price;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

interface UpdatePrice
{
    public function updatePrice(
        Product $product,
        Marketplace $marketplace,
        float $priceValue,
        ?float $commission = null
    ): bool;
}
