<?php

namespace Barrigudinha\Product\Repositories\Contracts;

use Barrigudinha\Product\Entities\ProductsCollection;

interface ListProducts
{
    public function all(): ProductsCollection;

    public function count(?Options $options = null): int;

    public function list(?Options $options = null): ProductsCollection;
}
