<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Domain\DataTransfer\CategoryCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Domain\Models\Product\Product;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
    ) {
    }

    public function get(Marketplace $marketplace, Product $product): float
    {
        if ($marketplace->hasUniqueCommission()) {
            return $marketplace->getUniqueCommission()->getFraction();
        }

        if ($marketplace->hasCommissionByCategory()) {
            return $marketplace->getCommissionByCategory(
                    $product->getCategoryId()
                )?->getFraction() ?? 0.0;
        }

        return 0.0;
    }

    /**
     * @param CategoryCommission[] $data
     */
    public function updateCategoryCommissions(string $marketplaceSlug, array $data): bool
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $marketplace->setCommissionsByCategory(collect($data));

        return $marketplace->save();
    }

    public function updateUniqueCommission(string $marketplaceSlug, float $commission): bool
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $marketplace->setCommissionByUniqueValue($commission);

        return $marketplace->save();
    }
}
