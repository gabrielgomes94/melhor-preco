<?php

namespace Src\Prices\Domain\Models\Calculator;

use Money\Money;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product\Product;

class CostPrice
{
    private Money $additionalCosts;
    private Money $purchasePrice;
    private Percentage $taxICMSInnerState;
    private Percentage $taxICMSOutterState;
    private Percentage $taxSimplesNacional;

    public function __construct(
        Money $purchasePrice,
        Money $additionalCosts,
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
            MoneyTransformer::toMoney($costs->purchasePrice()),
            MoneyTransformer::toMoney($costs->additionalCosts()),
            Percentage::fromPercentage($costs->taxICMS()),
            Percentage::fromPercentage($user->getIcmsInnerStateTaxRate()),
            Percentage::fromPercentage($user->getSimplesNacionalTaxRate())
        );
    }

    public function get(): Money
    {
        return $this->purchasePrice
            ->add($this->differenceICMS())
            ->add($this->additionalCosts);
    }

    public function purchasePrice(): Money
    {
        return $this->purchasePrice;
    }

    public function differenceICMS(): Money
    {
        $baseICMS = $this->purchasePrice->divide((string) (1 - $this->taxICMSOutterState->getFraction()));
        $outerStateICMSValue = $baseICMS->multiply(
            (string) $this->taxICMSOutterState->getFraction()
        );
        $baseDIFAL = $this->purchasePrice->divide((string)(1 - $this->taxICMSInnerState->getFraction()));

        $difal = $baseDIFAL
            ->multiply((string) $this->taxICMSInnerState->getFraction())
            ->subtract($outerStateICMSValue);

        return $difal;
    }

    public function simplesNacional(): float
    {
        return $this->taxSimplesNacional->getFraction();
    }
}
