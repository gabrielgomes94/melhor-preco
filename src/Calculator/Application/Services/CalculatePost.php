<?php

namespace Src\Calculator\Application\Services;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Products\Domain\Models\Post\Post;

class CalculatePost
{
    private CalculatePrice $service;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(CalculatePrice $service, MarketplaceRepository $marketplaceRepository)
    {
        $this->service = $service;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function calculate(array|Post $data, array $options = []): Price
    {
        $marketplace = $this->marketplaceRepository->getByErpId($data['marketplace_erp_id'] ?? '');

        // @todo: delete this line
        if (!$marketplace) {
            $marketplace = Marketplace::first();
        }

        return $this->service->calculate(
            productData: ProductData::fromArray($data),
            marketplace: $marketplace,
            value: $data['value'],
            commission: Percentage::fromPercentage($data['commission']),
            options: $options
        );
    }
}
