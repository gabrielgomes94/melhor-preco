<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator\Calculators;

use Barrigudinha\Pricing\Data\CostPrice;
use Barrigudinha\Product\Product;
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
    protected CostPrice $costPrice;
    protected Product $product;

    public function __construct(Product $product, float $commission, Money $additionalCosts, array $extra)
    {
        $this->product = $product;
        $this->commission = $commission;
        $this->additionalCosts = $additionalCosts;
        $this->setCostPrice($product, $additionalCosts);
    }

    abstract protected function calculate(): void;

    public function freight(): Money
    {
        return $this->freight->get() ?? Money::BRL(0);
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function costs(): Money
    {
        return $this->costs;
    }

    public function costPrice(): Money
    {
        return $this->costPrice->get();
    }

    public function purchasePrice(): Money
    {
        return $this->costPrice->purchasePrice();
    }

    public function differenceICMS(): Money
    {
        return $this->costPrice->differenceICMS();
    }

    public function commission(): Money
    {
        return $this->price->multiply($this->commission);
    }

    public function simplesNacional(): Money
    {
        return $this->price->multiply($this->taxSimplesNacional());
    }

    private function setCostPrice(Product $product, Money $additionalCosts): void
    {
        $this->costPrice = new CostPrice(
            Helpers::floatToMoney($product->purchasePrice()),
            $this->additionalCosts,
            Helpers::percentage($product->tax(Tax::ICMS)->rate)
        );
    }
}
