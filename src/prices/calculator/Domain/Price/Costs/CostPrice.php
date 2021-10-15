<?php

namespace Src\Prices\Calculator\Domain\Price\Costs;

use Barrigudinha\Utils\Helpers;
use Money\Money;

class CostPrice
{
    private Money $additionalCosts;
    private Money $purchasePrice;
    private float $taxICMSInnerState;
    private float $taxICMSOutterState;

    public function __construct(Money $purchasePrice, Money $additionalCosts, float $taxICMSOutterState)
    {
        $this->purchasePrice = $purchasePrice;
        $this->taxICMSOutterState = $taxICMSOutterState;
        $this->additionalCosts = $additionalCosts;
        $this->taxICMSInnerState = Helpers::percentage(config('taxes.ICMS.MG'));
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
        $baseICMS = $this->purchasePrice->divide(1 - $this->taxICMSOutterState);
        $outerStateICMSValue = $baseICMS->multiply($this->taxICMSOutterState);
        $baseDIFAL = $this->purchasePrice->divide(1 - $this->taxICMSInnerState);

        $difal = $baseDIFAL
            ->multiply($this->taxICMSInnerState)
            ->subtract($outerStateICMSValue);

        return $difal;
    }
}
