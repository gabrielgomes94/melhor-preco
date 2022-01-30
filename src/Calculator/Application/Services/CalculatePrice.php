<?php

namespace Src\Calculator\Application\Services;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Services\Contracts\CalculatePrices;

// @todo: Talvez seja interessante disponibilizar uma classe CalculateProduct
class CalculatePrice implements CalculatePrices
{
    public function calculate(
        ProductData $productData,
        Marketplace $marketplace,
        float $value,
        ?Percentage $commission,
        array $options = []
    ): Price {
        return new Price(
            product: $productData,
            marketplace: $marketplace,
            value: $value,
            commission: $this->getCommission($marketplace, $productData, $commission),
            options: $this->getOptions($options)
        );
    }

    private function getCommission(Marketplace $marketplace, ProductData $productData, ?Percentage $commission): float
    {
        if ($commission) {
            return $commission->getFraction();
        }

        if ($marketplace->hasUniqueCommission()) {
            return $marketplace->getUniqueCommission()->getFraction();
        }

        if ($marketplace->hasCommissionByCategory()) {
            return $marketplace->getCommissionByCategory(
                $productData->getCategory()->getCategoryId()
            )->getFraction();
        }

        return 0.0;
    }

    private function getOptions(array $options): array
    {
        return [
            self::IGNORE_FREIGHT => $options[self::IGNORE_FREIGHT] ?? false,
            self::DISCOUNT_RATE => $options[self::DISCOUNT_RATE] ?? Percentage::fromPercentage(0),
            self::COMMISSION => $options[self::COMMISSION] ?? null,
        ];
    }
}
