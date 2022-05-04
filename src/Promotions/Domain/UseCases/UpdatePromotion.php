<?php

namespace Src\Promotions\Domain\UseCases;

use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;
use Src\Promotions\Domain\Data\Entities\Promotion;
use Src\Promotions\Domain\Repositories\PromotionRepository;
use Src\Promotions\Domain\UseCases\Contracts\FilterProfitableProducts;

class UpdatePromotion
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private PromotionRepository $promotionRepository,
        private FilterProfitableProducts $filterProfitableProducts
    )
    {}

    /**
     * @throws MarketplaceNotFoundException
     */
    public function update(string $promotionUuid, PromotionSetup $data): Promotion
    {
        $marketplace = $this->marketplaceRepository->getBySlug($data->marketplaceSlug);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($data->marketplaceSlug);
        }

        $prices = $this->filterProfitableProducts->get($marketplace, $data);

        return $this->promotionRepository->update($promotionUuid, $data, $prices);
    }
}
