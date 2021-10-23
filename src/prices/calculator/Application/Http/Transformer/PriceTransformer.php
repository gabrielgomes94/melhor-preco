<?php

namespace Src\Prices\Calculator\Application\Http\Transformer;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Product\Contracts\Models\Post;

class PriceTransformer
{
    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct()
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function transform(Post $post): array
    {
        $data = [
            'price' => $this->setData($post->getPrice()),
            'secondaryPrice' => [],
        ];

        if ($post instanceof HasSecondaryPrice) {
            $data['secondaryPrice'] = $this->setData($post->getSecondaryPrice());
        }

        return $data;
    }

    private function setData(Price $price): array
    {
        return [
            'suggestedPrice' => MoneyTransformer::toString($price->get()),
            'costs' => MoneyTransformer::toString($price->getCosts()),
            'commission' => MoneyTransformer::toString($price->getCommission()->get()),
            'freight' => MoneyTransformer::toString($price->getFreight()->get()),
            'taxSimplesNacional' => MoneyTransformer::toString($price->getSimplesNacional()),
            'differenceICMS' => MoneyTransformer::toString($price->getDifferenceICMS()),
            'profit' => MoneyTransformer::toString($price->getProfit()),
            'purchasePrice' => MoneyTransformer::toString($price->getPurchasePrice()),
            'margin' => $price->getMargin()
        ];
    }

    private function format(Money $value): string
    {
        return $this->moneyFormatter->format($value);
    }
}
