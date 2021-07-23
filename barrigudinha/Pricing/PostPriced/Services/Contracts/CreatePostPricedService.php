<?php

namespace Barrigudinha\Pricing\PostPriced\Services\Contracts;

use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Product\Product;
use Barrigudinha\Product\Store;
use Money\Money;

interface CreatePostPricedService
{
    public function create(Product $product, Store $store, Money $price): PostPriced;
}
