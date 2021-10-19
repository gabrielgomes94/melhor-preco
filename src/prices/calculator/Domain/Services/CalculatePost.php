<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Prices\Calculator\Domain\Price\Price;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Store\Factory as StoreFactory;

class CalculatePost
{
    private CalculatePrice $service;

    public function __construct(CalculatePrice $service)
    {
        $this->service = $service;
    }

    public function calculate(array $data, array $options = []): Price
    {
        return $this->service->calculate(
            productData: new ProductData($data['costs'], $data['dimensions']),
            store: StoreFactory::make($data['store']),
            value: $data['value'],
            commission: $data['commission'],
            options: $options
        );
    }

}
