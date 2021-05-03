<?php

namespace App\Services\Pricing;

use App\Http\Transformers\Pricing\CalculatePriceTransformer;
use Barrigudinha\Pricing\Data\Product;
use Illuminate\Http\Request;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class CalculatePrice
{
    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct()
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function calculate(Product $product, Request $request)
    {
        $calculatePrice = new CalculatePriceTransformer($request, $product);

        if ($calculatePrice->desiredMargin) {
            return $this->calculateFromMargin($calculatePrice);
        }

        if ($calculatePrice->desiredSellingPrice) {
            return $this->calculateFromPrice($calculatePrice);
        }

        return [
            'profit' => '',
            'costs' => '',
            'suggestedPrice' => '',
            'margin' => '',
        ];
    }

    private function calculateFromMargin(CalculatePriceTransformer $calculatePrice)
    {
        // Calculate ICMS
//        $costPrice = $calculatePrice->purchasePrice
//            ->multiply(1 + $calculatePrice->taxIPI)
//            ->multiply(1 + $calculatePrice->taxICMSDifference);

        $costPrice = $this->calculateCostPrice($calculatePrice);

        $markup = 1 - $calculatePrice->commission - $calculatePrice->taxSimplesNacional - $calculatePrice->desiredMargin;
        $suggestedPrice = $costPrice->divide($markup);
        $commissionCut = $suggestedPrice->multiply($calculatePrice->commission);
        $taxSimplesNacionalCut = $suggestedPrice->multiply($calculatePrice->taxSimplesNacional);

        $costs = $costPrice
            ->add($commissionCut)
            ->add($taxSimplesNacionalCut)
            ->add($calculatePrice->additionalCosts);

        $profit = $suggestedPrice->subtract($costs);

        return [
            'profit' => $this->moneyFormatter->format($profit),
            'costs' => $this->moneyFormatter->format($costs),
            'suggestedPrice' => $this->moneyFormatter->format($suggestedPrice),
            'margin' => round($calculatePrice->desiredMargin * 100, 2),
        ];
    }

    private function calculateFromPrice(CalculatePriceTransformer $calculatePrice)
    {
//        $costPrice = $calculatePrice->purchasePrice
//            ->multiply(1 + $calculatePrice->taxIPI)
//            ->multiply(1 + $calculatePrice->taxICMSDifference);
        $costPrice = $this->calculateCostPrice($calculatePrice);

        $commissionCut = $calculatePrice->desiredSellingPrice->multiply($calculatePrice->commission);
        $taxSimplesNacionalCut = $calculatePrice->desiredSellingPrice->multiply($calculatePrice->taxSimplesNacional);

        $costs = $costPrice
            ->add($commissionCut)
            ->add($taxSimplesNacionalCut)
            ->add($calculatePrice->additionalCosts);

        $profit = $calculatePrice->desiredSellingPrice->subtract($costs);
        $margin = $profit->ratioOf($calculatePrice->desiredSellingPrice);

        return [
            'profit' => $this->moneyFormatter->format($profit),
            'costs' => $this->moneyFormatter->format($costs),
            'suggestedPrice' => $this->moneyFormatter->format($calculatePrice->desiredSellingPrice),
            'margin' => round($margin * 100, 2),
        ];
    }

    private function calculateCostPrice(CalculatePriceTransformer $calculatePrice): Money
    {
        $outerICMSValue = $calculatePrice
            ->purchasePrice
            ->multiply($calculatePrice->taxICMSDifference);
        $innerICMSValue = $calculatePrice->purchasePrice
            ->subtract($outerICMSValue)
            ->divide(1 - 0.18)
            ->multiply(0.18);

        $differenceICMS = $innerICMSValue->subtract($outerICMSValue);
        $costPrice = $calculatePrice->purchasePrice->add($differenceICMS);

        return $costPrice;
    }
}
