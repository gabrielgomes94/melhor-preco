<?php

namespace Src\Prices\Domain\UseCases\Contracts;

use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Store\Store;

interface UpdatePrice
{
    public function updatePrice(Product $product, Store $store, float $priceValue): bool;
}
