<?php

namespace Barrigudinha\Product\Repositories\Contracts;

use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;

interface ListProducts
{
    public function all(): ProductsCollection;

    public function count(Options $options): int;

    public function list(Options $options): ProductsCollection;
}
