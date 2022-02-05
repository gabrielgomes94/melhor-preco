<?php

namespace Src\Calculator\Application\Services;

use Src\Calculator\Domain\Models\Price\Price as CalculatedPrice;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Domain\Services\Contracts\CalculatePost as CalculatePostInterface;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;

class CalculatePost implements CalculatePostInterface
{
    private CalculatePrice $service;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(CalculatePrice $service, MarketplaceRepository $marketplaceRepository)
    {
        $this->service = $service;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function calculate(array|Post $data, array $options = []): CalculatedPrice
    {
        $marketplace = $this->marketplaceRepository->getByErpId($data['marketplace_erp_id'] ?? '');

        if (!$marketplace) {
            $marketplace = Marketplace::first();
        }

        return $this->service->calculate(
            productData: ProductData::fromArray($data),
            marketplace: $marketplace,
            value: $data['value'],
            commission: Percentage::fromFraction($data['commission']),
            options: $options
        );
    }

    public function calculatePost(Product $product, Price $price, array $options = []): CalculatedPrice
    {
        $marketplace = $price->getMarketplace();

        return $this->service->calculate(
            productData: ProductData::fromModel($product),
            marketplace: $marketplace,
            value: $price->getValue(),
            commission: $price->getCommission(),
            options: $options
        );
    }
}
