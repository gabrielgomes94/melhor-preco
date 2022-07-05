<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Domain\Models\Commission\CategoryCommission;
use Src\Marketplaces\Domain\Models\Commission\UniqueCommission;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
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
