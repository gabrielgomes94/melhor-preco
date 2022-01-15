<?php

namespace Src\Calculator\Application\Services;

use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Domain\Services\CalculatePrice;
use Src\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Domain\Models\Price;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Store\Factory;

class CalculateProfit
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    /**
     * @param Price $price
     * @return float
     * @throws ProductNotFoundException
     */
    public function fromModel(Price $price): float
    {
        $product = Product::where('sku', $price->product_sku)->first();

        if (!$product) {
            throw new ProductNotFoundException($price->product_sku);
        }

        $price = $this->calculatePrice->calculate(
            ProductData::fromModel($product),
            Factory::make($price->store),
            $price->value,
            Percentage::fromPercentage($price->commission ?? 0.0),
        );

        return MoneyTransformer::toFloat($price->getProfit());
    }
}