<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues;
use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Domain\Models\Commission\CategoryCommission;
use Src\Marketplaces\Domain\Models\Commission\UniqueCommission;
use Src\Marketplaces\Infrastructure\Laravel\Collections\CommissionValues as CommissionValuesCollection;
use Src\Math\Percentage;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function get(Marketplace $marketplace, ?string $categoryId = null): Percentage
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

    public function updateCategoryCommissions(Marketplace $marketplace, CommissionValues $data): bool
    {
        $marketplace->setCommissions($data);

        return $marketplace->save();
    }

    public function updateUniqueCommission(Marketplace $marketplace, float $commission): bool
    {
        $commissionValue = new CommissionValue(Percentage::fromPercentage($commission));

        $marketplace->setCommissions(
            new CommissionValuesCollection([$commissionValue])
        );

        return $marketplace->save();
    }
}
