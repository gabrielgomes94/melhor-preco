<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Money\Money;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Models\Commission\UniqueCommission;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Math\MoneyCalculator;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function get(Marketplace $marketplace, Product $product, float $value): float
    {
        $commission = $this->getCommissionRate($marketplace, $product->getCategoryId());
        $commissionValue = MoneyCalculator::multiply($value, $commission->getFraction());
        $commissionObject = $marketplace->getCommission();

        if (!$commissionObject->hasMaximumValueCap()) {
            return $commissionValue;
        }

        $maximumValueCap = MoneyTransformer::toMoney($commissionObject->getMaximumValueCap());

        if (MoneyTransformer::toMoney($commissionValue)->greaterThan($maximumValueCap)) {
            return MoneyTransformer::toFloat($maximumValueCap);
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
}
