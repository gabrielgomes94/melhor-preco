<?php

namespace Src\Calculator\Domain\Services;

use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Services\Contracts\CalculatePrices;
use Src\Products\Domain\Models\Store\Store;

// @todo: Talvez seja interessante disponibilizar uma classe CalculateProduct
class CalculatePrice implements CalculatePrices
{
    public function calculate(
        ProductData $productData,
        Store $store,
        float $value,
        ?Percentage $commission,
        array $options = []
    ): Price {
        return new Price(
            product: $productData,
            store: $store,
            value: $value,
            commission: $this->getCommission($store, $commission),
            options: $this->getOptions($options)
        );
    }

    private function getCommission(Store $store, ?Percentage $commission): float
    {
        return $commission
            ? $commission->get()
            : $store->getDefaultCommission();
    }

    private function getOptions(array $options): array
    {
        return [
            self::IGNORE_FREIGHT => $options[self::IGNORE_FREIGHT] ?? false,
            self::DISCOUNT_RATE => $options[self::DISCOUNT_RATE] ?? Percentage::fromPercentage(0),
        ];
    }
}