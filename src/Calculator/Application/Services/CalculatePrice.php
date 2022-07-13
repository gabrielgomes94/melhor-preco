<?php

namespace Src\Calculator\Application\Services;

use Src\Calculator\Domain\Models\Price\PriceFactory;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice;
use Src\Calculator\Domain\Services\Contracts\CalculatePrices;

/**
 * @deprecated
 */
class CalculatePrice implements CalculatePrices
{
    public function __construct(
        private CommissionRepository $commissionRepository
    ) {
    }

    public function calculate(
        ProductData $productData,
        Marketplace $marketplace,
        float $value,
        ?Percentage $commission = null,
        array $options = []
    ): CalculatedPrice {
        return PriceFactory::make(
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

        $commission = $this->commissionRepository->get(
            $marketplace,
            $productData->getCategory()?->getCategoryId()
        );

        return $commission->get();
    }

    private function getOptions(array $options): array
    {
        return [
            self::IGNORE_FREIGHT => $options[self::IGNORE_FREIGHT] ?? false,
            self::FREE_FREIGHT => $options[self::FREE_FREIGHT] ?? false,
            self::DISCOUNT_RATE => $options[self::DISCOUNT_RATE] ?? Percentage::fromPercentage(0),
            self::COMMISSION => $options[self::COMMISSION] ?? null,
        ];
    }
}
