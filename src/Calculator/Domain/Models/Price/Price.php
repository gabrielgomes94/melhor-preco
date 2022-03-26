<?php

namespace Src\Calculator\Domain\Models\Price;

use Money\Money;
use Src\Calculator\Domain\Models\Price\Commission\Commission;
use Src\Calculator\Domain\Models\Price\Contracts\Price as PriceInterface;
use Src\Calculator\Domain\Models\Price\Costs\CostPrice;
use Src\Calculator\Domain\Models\Price\Freight\BaseFreight as Freight;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Calculator\Domain\Transformer\PercentageTransformer;
use Src\Math\MoneyTransformer;

class Price implements PriceInterface
{
    public function __construct(
        private CostPrice $costPrice,
        private Freight $freight,
        private Commission $commission,
        private Money $value
    ) {}

    public function get(): Money
    {
        return $this->value;
    }

    public function getCommission(): Commission
    {
        return $this->commission;
    }

    public function getCostPrice(): CostPrice
    {
        return $this->costPrice;
    }

    public function getCosts(): Money
    {
        return $this->getCostPrice()->get()
            ->add($this->getCommission()->get())
            ->add($this->getSimplesNacional())
            ->add($this->getFreight()->get());
    }

    public function getDifferenceICMS(): Money
    {
        return $this->costPrice->differenceICMS();
    }

    public function getFreight(): Freight
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

    public function getProductData(): ProductData
    {
        return $this->product;
    }

    public function getProfit(): Money
    {
        return $this->value->subtract($this->getCosts());
    }

    public function getPurchasePrice(): Money
    {
        return $this->costPrice->purchasePrice();
    }

    public function getSimplesNacional(): Money
    {
        return $this->value->multiply(
            PercentageTransformer::toPercentage(config('taxes.simples_nacional'))
        );
    }

    public function __toString(): string
    {
        return MoneyTransformer::toString($this->value);
    }

    public function isProfitable(): bool
    {
        return $this->getProfit()->greaterThan(Money::BRL(0));
    }
}
