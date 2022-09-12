<?php

namespace Src\Prices\Domain\Models\Calculator;

use Src\Math\Calculators\MoneyCalculator;
use Src\Math\Calculators\ProfitMargin;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Products\Domain\Models\Product;

class CalculatedPrice
{
    public function __construct(
        private readonly CostPrice $costPrice,
        private readonly float $value,
        private readonly float $commission,
        private readonly float $freight
    ) {
    }

    public static function fromProduct(
        Product $product,
        float $commission,
        CalculatorForm $options
    ): self
    {
        return new self(
            CostPrice::fromProduct($product),
            $options->getPrice(),
            $commission,
            $options->freight,
        );
    }

    public function get(): float
    {
        return $this->value;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function getCostPrice(): CostPrice
    {
        return $this->costPrice;
    }

    public function getCosts(): float
    {
        return MoneyCalculator::sum(
            $this->getCostPrice()->get(),
            $this->getCommission(),
            $this->getSimplesNacional(),
            $this->getFreight()
        );
    }

    public function getDifferenceICMS(): float
    {
        return $this->costPrice->differenceICMS();
    }

    public function getFreight(): float
    {
        return $this->freight;
    }

    public function getMargin(): float
    {
        return ProfitMargin::calculate($this->value, $this->getProfit())
            ->get();
    }

    public function getProfit(): float
    {
        return round($this->value - $this->getCosts(), 2);
    }

    public function getPurchasePrice(): float
    {
        return $this->costPrice->purchasePrice();
    }

    public function getSimplesNacional(): float
    {
        return MoneyCalculator::multiply($this->value, $this->costPrice->simplesNacional());
    }

    public function isProfitable(): bool
    {
        return $this->getProfit() > 0.0;
    }
}
