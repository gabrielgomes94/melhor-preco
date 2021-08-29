<?php

namespace App\Repositories\Pricing\Product\Filters\Contracts;

use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;

interface Filter
{
    public static function execute(ProductsCollection $productsCollection, Options $options): ProductsCollection;
}
