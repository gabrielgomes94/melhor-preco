<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Prices\Calculator\Domain\Contracts\Models\ProductData;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Store\Store;

class CalculatePrice
{
//    private array $availableOptions = [
//        'commission',
//        'ignoreFreight',
//        'discountRate',
//    ];

    public function calculate(
        ProductData $productData,
        Store $store,
        float $value,
        ?float $commission,
        array $options = []
    ): Price {
        return new Price(
            product: $productData,
            store: $store,
            value: $value,
            commission: $commission ?? $store->getDefaultCommission(),
            options: $options
        );
    }
}
