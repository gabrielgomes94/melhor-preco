<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Money\Money;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\CategoryCommission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Models\Commission\UniqueCommission;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product\Product;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function get(Marketplace $marketplace, Product $product, Money $value): Money
    {
        $commission = $this->getCommissionRate($marketplace, $product->getCategoryId());
        $commissionValue = $value->multiply((string) $commission->getFraction());
        $commissionObject = $marketplace->getCommission();

        if (!$commissionObject->hasMaximumValueCap()) {
            return $commissionValue;
        }

        $maximumValueCap = MoneyTransformer::toMoney(
            $commissionObject->getMaximumValueCap()
        );

        if ($commissionValue->greaterThan($maximumValueCap)) {
            return $maximumValueCap;
        }

        return $commissionValue;
    }

    public function getCommissionRate(Marketplace $marketplace, ?string $categoryId = null): Percentage
    {
        $commission = $marketplace->getCommission();

        if ($commission instanceof UniqueCommission) {
            return $commission->get();
        }

        if ($commission instanceof CategoryCommission) {
            return $commission->get($categoryId) ?? Percentage::fromPercentage(0.0);
        }

        return Percentage::fromPercentage(0.0);
    }

    public function update(Marketplace $marketplace, CommissionValuesCollection $data): bool
    {
        $marketplace->setCommissions($data);

        return $marketplace->save();
    }
}
