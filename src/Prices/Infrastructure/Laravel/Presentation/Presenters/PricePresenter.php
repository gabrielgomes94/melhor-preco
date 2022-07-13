<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Presenters;

use Money\Money;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Calculator\Contracts\Price;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Post\Contracts\Post;

class PricePresenter
{
    public function transformRaw(Post $post): array
    {
        $price = $post->getCalculatedPrice();
        $commissionRate = $price->getCommission()->getCommissionRate() * 100;

        return [
            'commission' => $this->transformMoney($price->getCommission()->get()),
            'commissionRate' => $commissionRate,
            'costs' => $this->transformMoney($price->getCosts()),
            'differenceICMS' => $this->transformMoney($price->getDifferenceICMS()),
            'freight' => $this->transformMoney($price->getFreight()->get()),
            'margin' => $price->getMargin(),
            'marketplaceSlug' => $post->getMarketplace()->getSlug(),
            'priceId' => $post->getId(),
            'profit' => $this->transformMoney($price->getProfit()),
            'purchasePrice' => $this->transformMoney($price->getPurchasePrice()),
            'suggestedPrice' => $this->transformMoney($price->get()),
            'taxSimplesNacional' => $this->transformMoney($price->getSimplesNacional()),
        ];
    }

    public function format(Post $post): array
    {
        $price = $post->getCalculatedPrice();
        $commissionRate = $price->getCommission()->getCommissionRate() * 100;

        return [
            'commission' => MathPresenter::money($price->getCommission()->get()),
            'commissionRate' => $commissionRate,
            'costs' => MathPresenter::money($price->getCosts()),
            'differenceICMS' => MathPresenter::money($price->getDifferenceICMS()),
            'freight' => MathPresenter::money($price->getFreight()->get()),
            'marketplaceSlug' => $post->getMarketplace()->getSlug(),
            'margin' => MathPresenter::percentage(
                Percentage::fromPercentage($price->getMargin())
            ),
            'priceId' => $post->getId(),
            'profit' => MathPresenter::money($price->getProfit()),
            'purchasePrice' => MathPresenter::money($price->getPurchasePrice()),
            'suggestedPrice' => MathPresenter::money($price->get()),
            'taxSimplesNacional' => MathPresenter::money($price->getSimplesNacional()),
        ];
    }

    private function transformMoney(Money $money): float
    {
        return MoneyTransformer::toFloat($money);
    }
}
