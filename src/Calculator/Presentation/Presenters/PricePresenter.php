<?php

namespace Src\Calculator\Presentation\Presenters;

use Money\Money;
use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Contracts\Price;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Product\Contracts\Post;

class PricePresenter
{
    public function transform(Post $post): array
    {
        $price = $post->getCalculatedPrice();
        $commissionRate = $price->getCommission()->getCommissionRate() * 100;

        return [
            'suggestedPrice' => $this->transformMoney($price->get()),
            'costs' => $this->transformMoney($price->getCosts()),
            'commission' => $this->transformMoney($price->getCommission()->get()),
            'commissionRate' => $commissionRate,
            'freight' => $this->transformMoney($price->getFreight()->get()),
            'taxSimplesNacional' => $this->transformMoney($price->getSimplesNacional()),
            'differenceICMS' => $this->transformMoney($price->getDifferenceICMS()),
            'marketplaceSlug' => $post->getMarketplace()->getSlug(),
            'profit' => $this->transformMoney($price->getProfit()),
            'purchasePrice' => $this->transformMoney($price->getPurchasePrice()),
            'margin' => $price->getMargin(),
            'priceId' => $post->getId(),
        ];
    }

    private function transformMoney(Money $money): float
    {
        return MoneyTransformer::toString($money);
    }
}
