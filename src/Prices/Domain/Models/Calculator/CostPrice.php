<?php

namespace Src\Prices\Domain\Models\Calculator;

use Money\Money;
use Src\Math\Calculators\MoneyCalculator;
use Src\Math\Transformers\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product;

class CostPrice
{
    private float $additionalCosts;
    private float $purchasePrice;
    private Percentage $taxICMSInnerState;
    private Percentage $taxICMSOutterState;
    private Percentage $taxSimplesNacional;

    public function __construct(
        float $purchasePrice,
        float $additionalCosts,
        Percentage $taxICMSOutterState,
        Percentage $taxICMSInnerState,
        Percentage $taxSimplesNacional
    )
    {
        $this->purchasePrice = $purchasePrice;
        $this->taxICMSOutterState = $taxICMSOutterState;
        $this->additionalCosts = $additionalCosts;
        $this->taxICMSInnerState = $taxICMSInnerState;
        $this->taxSimplesNacional = $taxSimplesNacional;
    }

    public static function fromProduct(Product $product): static
    {
        $costs = $product->getCosts();
        $user = $product->getUser();

        return new self(
            $costs->purchasePrice(),
            $costs->additionalCosts(),
            Percentage::fromPercentage($costs->taxICMS()),
            Percentage::fromPercentage($user->getIcmsInnerStateTaxRate()),
            Percentage::fromPercentage($user->getSimplesNacionalTaxRate())
        );
    }

    public function get(): float
    {
        return MoneyCalculator::sum($this->purchasePrice, $this->differenceICMS(), $this->additionalCosts);
    }

    public function total(): float
    {
        return MoneyCalculator::multiply(
            $this->get(),
            1 + $this->simplesNacional()
        );
    }

    public function purchasePrice(): float
    {
        return $this->purchasePrice;
    }

    public function differenceICMS(): float
    {
        $baseICMS = MoneyCalculator::divide(
            $this->purchasePrice,
            1 - $this->taxICMSOutterState->getFraction()
        );

        $outerStateICMSValue = MoneyCalculator::multiply(
            $baseICMS,
            $this->taxICMSOutterState->getFraction()
        );

        $baseDIFAL = MoneyCalculator::divide(
            $this->purchasePrice,
            1 - $this->taxICMSInnerState->getFraction()
        );

        $difal = MoneyCalculator::multiply($baseDIFAL, $this->taxICMSInnerState->getFraction());

        return MoneyCalculator::subtract($difal, $outerStateICMSValue);
    }

    public function simplesNacional(): float
    {
        return $this->taxSimplesNacional->getFraction();
    }
}
