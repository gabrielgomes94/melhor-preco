<?php

namespace Src\Prices\Domain\UseCases\Contracts;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

interface UpdatePrice
{
    public function updatePrice(Product $product, Marketplace $marketplace, float $priceValue, ?float $commission = null): bool;
}
