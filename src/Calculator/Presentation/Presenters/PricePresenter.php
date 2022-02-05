<?php

namespace Src\Calculator\Presentation\Presenters;

use Money\Money;
use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Product\Contracts\Post;

class PricePresenter
{
    public function transform(Post $post): array
    {
        $data = [
            'price' => $this->setData($post->getCalculatedPrice()),
            'secondaryPrice' => [],
        ];

        if ($post instanceof HasSecondaryPrice) {
            $data['secondaryPrice'] = $this->setData($post->getSecondaryPrice());
        }

        return $data;
    }

    private function setData(Price $price): array
    {
        $commissionRate = $price->getCommission()->getCommissionRate() * 100;

        return [
            'suggestedPrice' => $this->transformMoney($price->get()),
            'costs' => $this->transformMoney($price->getCosts()),
            'commission' => $this->transformMoney($price->getCommission()->get()),
            'commissionRate' => $commissionRate,
            'freight' => $this->transformMoney($price->getFreight()->get()),
            'taxSimplesNacional' => $this->transformMoney($price->getSimplesNacional()),
            'differenceICMS' => $this->transformMoney($price->getDifferenceICMS()),
            'profit' => $this->transformMoney($price->getProfit()),
            'purchasePrice' => $this->transformMoney($price->getPurchasePrice()),
            'margin' => $price->getMargin()
        ];
    }

    private function transformMoney(Money $money): float
    {
        return MoneyTransformer::toString($money);
    }
}
