<?php

namespace Src\Prices\Domain\Models\Calculator;

use Money\Money;
use Src\Math\Percentage;

class CalculatedPrice implements Contracts\CalculatedPrice
{
    public function __construct(
        private CostPrice $costPrice,
        private Money $value,
        private Percentage $commission,
        private Money $freight
    ) {
    }

    public function get(): Money
    {
        return $this->value;
    }

    public function getCommission(): Money
    {
        return $this->value->multiply(
            (string) $this->commission->getFraction()
        );
    }

    public function getCostPrice(): CostPrice
    {
        return $this->costPrice;
    }

    public function getCosts(): Money
    {
        return $this->getCostPrice()->get()
            ->add($this->getCommission())
            ->add($this->getSimplesNacional())
            ->add($this->getFreight());
    }

    public function getDifferenceICMS(): Money
    {
        return $this->costPrice->differenceICMS();
    }

    public function getFreight(): Money
    {
        return $this->freight;
    }

    public function getMargin(): float
    {
        $margin = 0.0;

        if (!$this->value->isZero()) {
            $margin = $this->getProfit()->ratioOf($this->value);
        }

        return round($margin * 100, 2);
    }

    public function getProfit(): Money
    {
        return $this->value->subtract(
            $this->getCosts()
        );
    }

    public function getPurchasePrice(): Money
    {
        return $this->costPrice->purchasePrice();
    }

    public function getSimplesNacional(): Money
    {
        return $this->value->multiply(
            (string) $this->costPrice->simplesNacional()
        );
    }

    public function isProfitable(): bool
    {
        return $this->getProfit()->greaterThan(Money::BRL(0));
    }
}
