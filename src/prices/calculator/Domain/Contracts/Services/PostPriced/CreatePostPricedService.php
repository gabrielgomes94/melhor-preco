<?php

namespace Src\Prices\Calculator\Domain\Contracts\Services\PostPriced;

use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Store;
use Money\Money;
use Src\Prices\Calculator\Domain\PostPriced\PostPriced;

interface CreatePostPricedService
{
    public function create(Product $product, Store $store, Money $price): \Src\Prices\Calculator\Domain\PostPriced\PostPriced;
}
