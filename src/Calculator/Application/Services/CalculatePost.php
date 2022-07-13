<?php

namespace Src\Calculator\Application\Services;

use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as CalculatedPrice;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Domain\Services\Contracts\CalculatePost as CalculatePostInterface;
use Src\Prices\Infrastructure\Laravel\Models\Price;

/**
 * @deprecated
 */
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
