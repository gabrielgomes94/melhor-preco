<?php

namespace Src\Prices\Calculator\Application\UseCases;

use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Price\Domain\Models\Price;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Product\Models\Product;
use Src\Products\Domain\Store\Factory;

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
        $product = Product::where('sku', $price->product_id)->get()->first();

        if (!$product) {
            throw new ProductNotFoundException($price->product_id);
        }

        $price = $this->calculatePrice->calculate(
            ProductData::fromModel($product),
            Factory::make($price->store),
            $price->value,
            $price->commission,
        );

        return MoneyTransformer::toFloat($price->getProfit());
    }
}
