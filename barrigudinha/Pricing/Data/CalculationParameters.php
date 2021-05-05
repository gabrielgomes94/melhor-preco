<?php

namespace Barrigudinha\Pricing\Data;

use Money\Money;

class CalculationParameters
{
    public Money $purchasePrice;
    public Money $additionalCosts;
    public float $commission;
    public float $taxICMSOutterState;
    public float $taxICMSInnerState;
    public ?float $desiredMargin;
    public ?Money $desiredSellingPrice;
    private Money $costPrice;

    public function __construct(Product $product, array $data)
    {
        $this->purchasePrice = $this->setMoneyFromFloat($product->purchasePrice());

        $this->commission =  $this->setPercentage($data['commission']);
        $this->taxICMSInnerState = $this->setPercentage(config('taxes.ICMS.MG'));
        $this->taxICMSOutterState = $this->setPercentage($product->tax(Tax::ICMS)->rate);
        $this->taxSimplesNacional = $this->setPercentage(config('taxes.simples_nacional'));

        $this->desiredMargin =  $data['desiredMargin']
            ? $this->setPercentage($data['desiredMargin'])
            : null;

        $this->desiredSellingPrice = $data['desiredPrice']
            ? $this->setMoneyFromFloat($data['desiredPrice'])
            : null;

        $this->additionalCosts = $this->setMoneyFromFloat($data['additionalCosts']);
    }

    public function costPrice(): Money
    {
        $this->costPrice = $this->purchasePrice
            ->add($this->differenceICMS())
            ->add($this->additionalCosts);

        return $this->costPrice;
    }

    private function differenceICMS(): Money
    {
        $baseICMS = $this->purchasePrice->divide(1 - $this->taxICMSOutterState);
        $outerStateICMSValue = $baseICMS->multiply($this->taxICMSOutterState);
        $baseDIFAL = $this->purchasePrice->divide(1 - $this->taxICMSInnerState);

        $difal = $baseDIFAL
            ->multiply($this->taxICMSInnerState)
            ->subtract($outerStateICMSValue);

        return $difal;
    }

    private function setMoneyFromFloat(float $value): Money
    {
        return Money::BRL((int) ($value * 100));
    }

    private function setPercentage(float $value): float
    {
        return $value / 100;
    }
}
