<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator\Calculators;

use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Services\PriceCalculator\Freight;
use Barrigudinha\Pricing\Services\PriceCalculator\Markup;
use Money\Money;

class FromMargin extends BaseCalculator
{
    private float $desiredMargin;

    public function __construct(
        Product $product,
        float $commission,
        Money $additionalCosts,
        array $extra
    ) {
        parent::__construct($product, $commission, $additionalCosts, $extra);

        $this->desiredMargin = $extra['desiredMargin'] ?? 0.0;
        $this->price = $this->setPrice();
        $this->calculate();
    }

    protected function calculate(): void
    {
        $freight = (new Freight($this->product))->get();

        $this->costs = $this->costPrice
            ->add($this->commission())
            ->add($this->simplesNacional())
            ->add($freight);
    }

    private function setPrice(): Money
    {
        $markup = Markup::calculate($this->commission, $this->taxSimplesNacional(), $this->desiredMargin);
        return $this->costPrice->divide($markup);
    }
}
