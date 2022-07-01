<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Domain\DataTransfer\CategoryCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product\Product;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function __construct(
//        private readonly MarketplaceRepository $marketplaceRepository,
    ) {
    }

    public function get(Marketplace $marketplace, Product $product): Percentage
    {
        if ($marketplace->hasUniqueCommission()) {
            return $marketplace->getUniqueCommission();
        }

        if ($marketplace->hasCommissionByCategory()) {
            return $marketplace->getCommissionByCategory($product->getCategoryId())
                ?? Percentage::fromPercentage(0.0);
        }

        return Percentage::fromPercentage(0.0);
    }

    /**
     * @param CategoryCommission[] $data
     */
    public function updateCategoryCommissions(Marketplace $marketplace, array $data): bool
    {
        $marketplace->setCommissionsByCategory(collect($data));

        return $marketplace->save();
    }

    public function updateUniqueCommission(Marketplace $marketplace, float $commission): bool
    {
        $marketplace->setCommissionByUniqueValue($commission);

        return $marketplace->save();
    }
}
