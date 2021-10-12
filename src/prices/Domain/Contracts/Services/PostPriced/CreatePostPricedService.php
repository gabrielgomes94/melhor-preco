<?php

namespace Src\Prices\Domain\Contracts\Services\PostPriced;

use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Store;
use Money\Money;
use Src\Prices\Domain\PostPriced\PostPriced;

interface CreatePostPricedService
{
    public function create(Product $product, Store $store, Money $price): PostPriced;
}
