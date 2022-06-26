<?php

namespace Src\Promotions\Domain\UseCases;

use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Promotions\Domain\Data\PromotionSetup;
use Src\Promotions\Domain\Models\Promotion;
use Src\Promotions\Domain\Repositories\Repository;
use Src\Promotions\Domain\Services\FilterProfitableProducts;
use Src\Promotions\Domain\UseCases\Contracts\CalculatePromotions as CalculatePromotionsInterface;

class CalculatePromotions implements CalculatePromotionsInterface
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private Repository $repository,
        private FilterProfitableProducts $filterProfitableProducts
    )
    {}

    public function calculate(PromotionSetup $data): Promotion
    {
        $marketplace = $this->marketplaceRepository->getBySlug($data->marketplaceSlug);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException();
        }

        return $this->repository->create(
            $data,
            $this->filterProfitableProducts->get($marketplace, $data)
        );
    }
}
