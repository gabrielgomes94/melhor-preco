<?php

namespace App\Http\Transformers\Pricing;

use Barrigudinha\Pricing\Data\PostPriced\MagaluPostPriced;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Pricing\Data\Price;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class PriceTransformer
{
    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct()
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function transform(PostPriced $postPriced): array
    {
        $data = [
            'price' => $this->setData($postPriced->price()),
            'discountedPrice' => [],
        ];

        if ($postPriced instanceof MagaluPostPriced) {
            $data['discountedPrice'] = $this->setData($postPriced->discountedPrice());
        }

        return $data;
    }

    private function setData(Price $price): array
    {
        return [
            'suggestedPrice' => $this->format($price->get()),
            'costs' => $this->format($price->costs()),
            'commission' => $this->format($price->commission()),
            'freight' => $this->format($price->freight()),
            'taxSimplesNacional' => $this->format($price->simplesNacional()),
            'differenceICMS' => $this->format($price->differenceICMS()),
            'profit' => $this->format($price->profit()),
            'purchasePrice' => $this->format($price->purchasePrice()),
            'margin' => $price->margin()
        ];
    }

    private function format(Money $value): string
    {
        return $this->moneyFormatter->format($value);
    }
}
