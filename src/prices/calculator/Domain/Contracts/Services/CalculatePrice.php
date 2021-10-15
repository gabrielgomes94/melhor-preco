<?php

namespace Src\Prices\Calculator\Domain\Contracts\Services;

use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Store;
use Money\Money;
use Src\Prices\Calculator\Domain\Price\Price;

interface CalculatePrice
{
    public function calculate(Product $product, Store $store, Money $desiredPrice, array $options = []): Price;
}
