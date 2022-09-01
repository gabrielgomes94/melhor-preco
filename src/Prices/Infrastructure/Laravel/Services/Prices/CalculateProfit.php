<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Domain\Models\User;

class CalculateProfit
{
    public function __construct(
        private CommissionRepository $commissionRepository
    ) {
    }

    public function fromModel(Price $price, Product $product, Marketplace $marketplace): float
    {
        $commission = $this->commissionRepository->get(
            $marketplace,
            $product,
            $price->getValue()
        );

        $price = CalculatedPrice::fromProduct(
            $product,
            MoneyTransformer::toMoney($commission),
            new CalculatorForm(desiredPrice: $price->getValue())
        );

        return MoneyTransformer::toFloat($price->getProfit());
    }
}
