<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Promotions;

use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\DataTransfer\PromotionSetup;
use Src\Prices\Domain\Models\Promotion;
use Src\Prices\Domain\Repositories\PromotionsRepository;
use Src\Prices\Domain\Services\Promotions\FilterProfitableProducts;
use Src\Prices\Domain\Services\Promotions\CalculatePromotions as CalculatePromotionsInterface;

class CalculatePromotions implements CalculatePromotionsInterface
{
    public function __construct(
        private MarketplaceRepository    $marketplaceRepository,
        private PromotionsRepository     $repository,
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
