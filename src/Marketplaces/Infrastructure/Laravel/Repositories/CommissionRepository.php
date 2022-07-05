<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product\Product;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function get(Marketplace $marketplace, Product $product): Percentage
    {
        if ($marketplace->hasUniqueCommission()) {
            return $marketplace->getCommission()->getUniqueCommission();
        }

        if ($marketplace->hasCommissionByCategory()) {
            return $marketplace->getCommission()->getCommissionByCategory($product->getCategoryId())
                ?? Percentage::fromPercentage(0.0);
        }

        return Percentage::fromPercentage(0.0);
    }

    /**
     * @param CommissionValue[] $data
     */
    public function updateCategoryCommissions(Marketplace $marketplace, array $data): bool
    {
        $marketplace->setCommissions($data);

        return $marketplace->save();
    }

    public function updateUniqueCommission(Marketplace $marketplace, float $commission): bool
    {
        $marketplace->setCommissions([
            new CommissionValue(Percentage::fromPercentage($commission))
        ]);

        return $marketplace->save();
    }
}
