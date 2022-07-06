<?php

namespace Src\Calculator\Domain\Models\Price;

use Src\Calculator\Domain\Models\Price\Commission\Factories\Factory as CommissionFactory;
use Src\Calculator\Domain\Models\Price\Contracts\Price as PriceInterface;
use Src\Calculator\Domain\Models\Price\Costs\CostPrice;
use Src\Calculator\Domain\Models\Price\Freight\Factories\Factory;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Calculator\Domain\Transformer\PercentageTransformer;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;

class PriceFactory
{
    public static function make(
        ProductData $product,
        Marketplace $marketplace,
        float $value,
        float $commission,
        array $options = []
    ): PriceInterface {
        $discountRate = $options[CalculatorOptions::DISCOUNT_RATE] ?? Percentage::fromPercentage(0);
        $value = MoneyTransformer::toMoney($value)->multiply(1 - $discountRate->getFraction());

        return new Price(
            costPrice: self::getCostPrice($product),
            freight: Factory::make(
                $marketplace->getSlug(),
                $product->getDimensions(),
                $value,
                $options[CalculatorOptions::FREE_FREIGHT]
            ),
            commission: CommissionFactory::make($marketplace->getSlug(), $value, $commission),
            value: $value
        );
    }

    private static function getCostPrice(ProductData $product): CostPrice
    {
        $costs = $product->getCosts();

        return new CostPrice(
            MoneyTransformer::toMoney($costs->purchasePrice()),
            MoneyTransformer::toMoney($costs->additionalCosts()),
            PercentageTransformer::toPercentage($costs->taxICMS())
        );
    }
}
