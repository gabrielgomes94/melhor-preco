<?php

namespace Barrigudinha\Pricing\Data;

use Barrigudinha\Pricing\Services\PriceCalculator\Freight;
use Barrigudinha\Product\Product;
use Barrigudinha\Utils\Helpers;
use Money\Money;

class Price
{
    // TODO: calcular o preço e lucro diretamente nesse objeto

    private float $commissionRate;
    private float $margin;
    private CostPrice $costPrice;
    private Freight $freight;
    private Money $additionalCosts;
    private Money $costs;
    private Money $commission;
    private Money $differenceICMS;
    private Money $profit;
    private Money $purchasePrice;
    private Money $taxSimplesNacional;
    private Money $value;

    private Product $product;

    public function __construct(
        Product $product,
        Money $value,
        string $store,
        ?Money $additionalCosts = null,
        float $commission = 0.0,
        float $discountRate = 0.0
    ) {
        $this->product = $product;
        $this->commissionRate = $commission;
        $this->additionalCosts = $additionalCosts ?? Money::BRL(0);
        $this->setCostPrice($product);
        $this->value = $value->multiply(1 - Helpers::percentage($discountRate));
        $this->setFreight($store);
        $this->calculate();
    }

    private function calculate(): void
    {
        $this->costs = $this->costPrice()
            ->add($this->commission())
            ->add($this->simplesNacional())
            ->add($this->freight());


        $this->profit = $this->value->subtract($this->costs);
    }

    private function setFreight(string $store)
    {
        if ($store === 'olist') {
        }

        $this->freight = new Freight($this->product, $this->value);
    }

    public function additionalCosts(): Money
    {
        return Money::BRL(0);
    }


    public function get(): Money
    {
        return $this->value;
    }

    public function freight(): Money
    {
        return $this->freight->get() ?? Money::BRL(0);
    }

    public function price(): Money
    {
        return $this->value;
    }

    public function costs(): Money
    {
        return $this->costs;
    }

    public function costPrice(): Money
    {
        return $this->costPrice->get();
    }

    public function margin(): float
    {
        $margin = 0.0;

        if (!$this->value->isZero()) {
            $margin = $this->profit->ratioOf($this->value);
        }

        return round($margin * 100, 2);
    }

    public function profit(): Money
    {
        return $this->profit;
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
        return $this->value->multiply($this->commissionRate);
    }

    public function simplesNacional(): Money
    {
        return $this->value->multiply($this->taxSimplesNacional());
    }

    private function setCostPrice(Product $product): void
    {
        $this->costPrice = new CostPrice(
            Helpers::floatToMoney($product->purchasePrice()),
            $this->additionalCosts,
            Helpers::percentage($product->tax(Tax::ICMS)->rate)
        );
    }

    private function taxSimplesNacional(): float
    {
        return Helpers::percentage(config('taxes.simples_nacional'));
    }
}
