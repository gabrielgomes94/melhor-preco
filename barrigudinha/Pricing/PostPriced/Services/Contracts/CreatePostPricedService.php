<?php

namespace Barrigudinha\Pricing\PostPriced\Services\Contracts;

use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Product\Data\Store;
use Money\Money;

interface CreatePostPricedService
{
    public function create(Product $product, Store $store, Money $price): PostPriced;
}
