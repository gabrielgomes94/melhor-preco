<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Src\Products\Domain\Models\Product\Product;

class CalculatePriceFromMarkup
{
    public function __construct(
        private CommissionRepository $commissionRepository,
        private FreightRepository $freightRepository
    )
    {}

    public function get(Product $product, Marketplace $marketplace, float $markup): CalculatedPrice
    {
        $costs = CostPrice::fromProduct($product);
        $desiredPrice = $costs->get()->multiply((string) $markup);

        $commission = $this->commissionRepository->get(
            $marketplace,
            $product,
            $desiredPrice
        );
        $freight = $this->freightRepository->get(
            $marketplace,
            $product->getCubicWeight(),
            MoneyTransformer::toFloat($desiredPrice)
        );

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
