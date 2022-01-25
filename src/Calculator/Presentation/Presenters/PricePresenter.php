<?php

namespace Src\Calculator\Presentation\Presenters;

use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Product\Contracts\Post;

class PricePresenter
{
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
            'commissionRate' => $price->getCommission()->getCommissionRate(),
            'freight' => MoneyTransformer::toString($price->getFreight()->get()),
            'taxSimplesNacional' => MoneyTransformer::toString($price->getSimplesNacional()),
            'differenceICMS' => MoneyTransformer::toString($price->getDifferenceICMS()),
            'profit' => MoneyTransformer::toString($price->getProfit()),
            'purchasePrice' => MoneyTransformer::toString($price->getPurchasePrice()),
            'margin' => $price->getMargin()
        ];
    }
}
