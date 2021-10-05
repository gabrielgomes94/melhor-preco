<?php

namespace Src\Prices\Domain\Contracts\Services\PostPriced;

use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Product\Data\Store;
use Money\Money;
use Src\Prices\Domain\PostPriced\PostPriced;

interface CreatePostPricedService
{
    public function create(Product $product, Store $store, Money $price): PostPriced;
}
