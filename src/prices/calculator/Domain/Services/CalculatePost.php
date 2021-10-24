<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Store\Factory as StoreFactory;

class CalculatePost
{
    private CalculatePrice $service;

    public function __construct(CalculatePrice $service)
    {
        $this->service = $service;
    }

    public function calculate(array|Post $data, array $options = []): Price
    {
        if ($data instanceof Post) {
            return $this->service->calculate(
                productData: $data->getPrice()->getProductData(),
                store: $data->getStore(),
                value: MoneyTransformer::toFloat($data->getPrice()->get()),
                commission: $data->getPrice()->getCommission()->getCommissionRate(),
                options: $options
            );
        }

        return $this->service->calculate(
            productData: new ProductData($data['costs'], $data['dimensions']),
            store: StoreFactory::make($data['store']),
            value: $data['value'],
            commission: $data['commission'],
            options: $options
        );
    }

}
