<?php

namespace Src\Prices\Infrastructure\Repositories\Product\Filters\Contracts;

use Src\Products\Domain\Entities\ProductsCollection;
use Src\Products\Domain\Contracts\Utils\Options;

interface Filter
{
    public static function execute(ProductsCollection $productsCollection, \Src\Products\Domain\Contracts\Utils\Options $options): ProductsCollection;
}
