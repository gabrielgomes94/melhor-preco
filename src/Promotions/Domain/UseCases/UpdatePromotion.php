<?php

namespace Src\Promotions\Domain\UseCases;

use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Promotions\Domain\Data\PromotionSetup;
use Src\Promotions\Domain\Models\Promotion;
use Src\Promotions\Domain\Repositories\Repository;
use Src\Promotions\Domain\Services\FilterProfitableProducts;

class UpdatePromotion
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private Repository $repository,
        private FilterProfitableProducts $filterProfitableProducts
    )
    {}

    public function update(string $promotionUuid, PromotionSetup $data): Promotion
    {
        $marketplace = $this->getMarketplace($data);
        $products = $this->filterProfitableProducts->get($marketplace, $data);

        return $this->repository->update($promotionUuid, $data, $products);
    }

    private function getMarketplace(PromotionSetup $data): Marketplace
    {
        $marketplace = $this->marketplaceRepository->getBySlug($data->marketplaceSlug);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($data->marketplaceSlug);
        }

        return $marketplace;
    }
}
