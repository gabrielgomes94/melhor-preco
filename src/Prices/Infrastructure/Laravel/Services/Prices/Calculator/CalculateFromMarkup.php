<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices\Calculator;

use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Models\Product\Product;

class CalculateFromMarkup extends BaseCalculator
{
    public function get(Price $price, float $markup): CalculatedPrice
    {
        $product = $price->getProduct();
        $costs = CostPrice::fromProduct($product);
        $desiredPrice = $costs->get()->multiply((string) $markup);

        $commission = $this->getCommission($price, $desiredPrice);
        $freight = $this->getFreight($price, $desiredPrice);

        return CalculatedPrice::fromProduct(
            $product,
            $commission,
            new CalculatorForm(
                desiredPrice: MoneyTransformer::toFloat($desiredPrice),
                freight: $freight
            )
        );
    }
}
