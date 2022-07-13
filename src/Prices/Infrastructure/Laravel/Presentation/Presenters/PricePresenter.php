<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Presenters;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\Contracts\Price;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Post\Contracts\Post;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class PricePresenter
{
    public function __construct(
        private CommissionRepository $commissionRepository
    )
    {}

    public function transformRaw(CalculatedPrice $calculatedPrice, Marketplace $marketplace, Product $product): array
    {
        $price = $calculatedPrice;
        $commissionRate = $this->commissionRepository->get($marketplace, $product)->get();

        return [
            'commission' => $this->transformMoney($price->getCommission()),
            'commissionRate' => $commissionRate,
            'costs' => $this->transformMoney($price->getCosts()),
            'differenceICMS' => $this->transformMoney($price->getDifferenceICMS()),
            'freight' => $this->transformMoney($price->getFreight()),
            'margin' => $price->getMargin(),
            'marketplaceSlug' => $marketplace->getSlug(),
            'priceId' => $product->getPrice($marketplace)->getId(),
            'profit' => $this->transformMoney($price->getProfit()),
            'purchasePrice' => $this->transformMoney($price->getPurchasePrice()),
            'suggestedPrice' => $this->transformMoney($price->get()),
            'taxSimplesNacional' => $this->transformMoney($price->getSimplesNacional()),
        ];
    }

    public function format(CalculatedPrice $calculatedPrice, Marketplace $marketplace, Product $product): array
    {
        $commissionRate = $this->commissionRepository->get($marketplace, $product)->get();
        $price = $calculatedPrice;

        return [
            'commission' => MathPresenter::money($price->getCommission()),
            'commissionRate' => $commissionRate,
            'costs' => MathPresenter::money($price->getCosts()),
            'differenceICMS' => MathPresenter::money($price->getDifferenceICMS()),
            'freight' => MathPresenter::money($price->getFreight()),
            'marketplaceSlug' => $marketplace->getSlug(),
            'margin' => MathPresenter::percentage(
                Percentage::fromPercentage($price->getMargin())
            ),
            'priceId' => $product->getPrice($marketplace)->getId(),
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
