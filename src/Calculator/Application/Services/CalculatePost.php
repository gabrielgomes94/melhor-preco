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

    public function __construct(CalculatePrice $service)
    {
        $this->service = $service;
    }

    public function calculatePost(Price $price, array $options = []): CalculatedPrice
    {
        $marketplace = $price->getMarketplace();

        return $this->service->calculate(
            productData: ProductData::fromModel($price->getProduct()),
            marketplace: $marketplace,
            value: $price->getValue(),
            commission: $price->getCommission(),
            options: $options
        );
    }
}
