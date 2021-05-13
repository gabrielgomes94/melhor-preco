<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator\Calculators;

use Barrigudinha\Pricing\Data\CostPrice;
use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Data\Tax;
use Barrigudinha\Pricing\Services\PriceCalculator\Freight;
use Barrigudinha\Pricing\Services\PriceCalculator\SimplesNacional;
use Barrigudinha\Utils\Helpers;
use Money\Money;

abstract class BaseCalculator
{
    use SimplesNacional;

    protected float $commission;
    protected float $taxSimplesNacional;
    protected Freight $freight;
    protected Money $additionalCosts;
    protected Money $costs;
    protected Money $price;
    protected Money $costPrice;
    protected Product $product;

    public function __construct(Product $product, float $commission, Money $additionalCosts, array $extra)
    {
        $this->product = $product;
        $this->commission = $commission;
        $this->additionalCosts = $additionalCosts;
        $this->costPrice = $this->setCostPrice($product, $additionalCosts);
    }

    protected abstract function calculate(): void;

    public function price(): Money
    {
        return $this->price;
    }

    public function costs(): Money
    {
        return $this->costs;
    }

    protected function commission(): Money
    {
        return $this->price->multiply($this->commission);
    }

    protected function simplesNacional(): Money
    {
        return $this->price->multiply($this->taxSimplesNacional());
    }

    private function setCostPrice(Product $product, Money $additionalCosts): Money
    {
        return (new CostPrice(
            Helpers::floatToMoney($product->purchasePrice()),
            $this->additionalCosts,
            Helpers::percentage($product->tax(Tax::ICMS)->rate)
        ))->get();
    }
}
