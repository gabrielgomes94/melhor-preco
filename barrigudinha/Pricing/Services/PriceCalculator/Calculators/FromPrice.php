<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator\Calculators;

use Barrigudinha\Pricing\Data\Product;
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

        $this->price = $extra['desiredPrice'] ?? 0.0;

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

    private function setFreight(array $extra)
    {
        if ($extra['store']) {
        }
        $this->freight = new Freight($this->product, $this->price);
    }
}
