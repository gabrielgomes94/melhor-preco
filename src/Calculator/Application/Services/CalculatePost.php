<?php

namespace Src\Calculator\Application\Services;

use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Store\Factory as StoreFactory;

class CalculatePost
{
    private CalculatePrice $service;

    public function __construct(CalculatePrice $service)
    {
        $this->service = $service;
    }

    public function calculate(array|Post $data, array $options = []): Price
    {
        return $this->service->calculate(
            productData: ProductData::fromArray($data),
            store: StoreFactory::make($data['store']),
            value: $data['value'],
            commission: Percentage::fromPercentage($data['commission']),
            options: $options
        );
    }
}
