<?php

namespace Src\Prices\Application\Http\Transformer;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Src\Prices\Domain\PostPriced\Contracts\HasSecondaryPrice;
use Src\Prices\Domain\PostPriced\PostPriced;
use Src\Prices\Domain\Price\Price;

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
            'secondaryPrice' => [],
        ];

        if ($postPriced instanceof HasSecondaryPrice) {
            $data['secondaryPrice'] = $this->setData($postPriced->secondaryPrice());
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
