<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Promotions;

use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\DataTransfer\PromotionSetup;
use Src\Prices\Domain\Models\Promotion;
use Src\Prices\Domain\Repositories\PromotionsRepository;
use Src\Prices\Domain\UseCases\FilterProfitableProducts;

class UpdatePromotion
{
    public function __construct(
        private MarketplaceRepository    $marketplaceRepository,
        private PromotionsRepository     $repository,
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
