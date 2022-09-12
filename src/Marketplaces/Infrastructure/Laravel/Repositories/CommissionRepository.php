<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Models\Commission\UniqueCommission;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Math\Calculators\MoneyCalculator;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function get(Marketplace $marketplace, Product $product, float $value): float
    {
        $commissionRate = $this->getCommissionRate($marketplace, $product->getCategoryId())->getFraction();
        $commissionValue = MoneyCalculator::multiply($value, $commissionRate);
        $commission = $marketplace->getCommission();

        if (!$commission->hasMaximumValueCap()) {
            return $commissionValue;
        }

        if ($this->isCommissionValueGreaterThanMaximumCap($commission, $commissionValue)) {
            return $commission->getMaximumValueCap();
        }

        return $commissionValue;
    }

    public function getCommissionRate(Marketplace $marketplace, ?string $categoryId = null): Percentage
    {
        $commission = $marketplace->getCommission();

        if ($commission instanceof UniqueCommission) {
            return $commission->get();
        }

        return $commission->get($categoryId) ?? Percentage::fromPercentage(0.0);
    }

    public function update(Marketplace $marketplace, CommissionValuesCollection $data): bool
    {
        $marketplace->setCommissions($data);

        return $marketplace->save();
    }

    private function isCommissionValueGreaterThanMaximumCap(Commission $commission, float $commissionValue): bool
    {
        return $commissionValue > $commission->getMaximumValueCap();
    }
}
