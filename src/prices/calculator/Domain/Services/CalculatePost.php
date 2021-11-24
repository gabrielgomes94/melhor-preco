<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
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
            $price = $data->getPrice();
            $commission = Percentage::fromFraction(
                $price->getCommission()->getCommissionRate()
            );

            return $this->service->calculate(
                productData: $price->getProductData(),
                store: $data->getStore(),
                value: MoneyTransformer::toFloat($price->get()),
                commission: $commission,
                options: $options
            );
        }

        return $this->service->calculate(
            productData: new ProductData($data['costs'], $data['dimensions']),
            store: StoreFactory::make($data['store']),
            value: $data['value'],
            commission: Percentage::fromPercentage($data['commission']),
            options: $options
        );
    }

}
