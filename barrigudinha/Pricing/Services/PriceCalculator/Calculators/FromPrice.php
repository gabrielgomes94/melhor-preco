<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator\Calculators;

use Barrigudinha\Pricing\Data\Freight\B2W;
use Barrigudinha\Pricing\Data\Freight\NoFreight;
use Barrigudinha\Pricing\Data\Freight\Olist;
use Barrigudinha\Product\Product;
use Barrigudinha\Pricing\Services\PriceCalculator\Freight;
use Money\Money;

class FromPrice extends BaseCalculator
{
    public function __construct(
        Product $product,
        float $commission,
        Money $additionalCosts,
        array $extra
    ) {
        parent::__construct($product, $commission, $additionalCosts, $extra);

        $this->price = $extra['desiredPrice'] ?? Money::BRL(0);

        $this->setFreight($extra);
        $this->calculate();
    }

    protected function calculate(): void
    {
        $this->costs = $this->costPrice()
            ->add($this->commission())
            ->add($this->simplesNacional())
            ->add($this->freight());
    }

    private function setFreight(array $extra): void
    {
        $this->freight = new NoFreight($this->product, $this->price);

        if ('olist' == $extra['store']) {
            $this->freight = new Olist($this->product, $this->price);
        } elseif ('b2w' == $extra['store']) {
            $this->freight = new B2W($this->product, $this->price);
        }
    }
}
