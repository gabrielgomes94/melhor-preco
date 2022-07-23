<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Math\Percentage;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class CalculatedPricePresenter
{
    public function __construct(
        private CommissionRepository $commissionRepository
    )
    {}

    public function present(CalculatedPrice $calculatedPrice, Marketplace $marketplace, Product $product): array
    {
        return [
            'formatted' => $this->format($calculatedPrice, $marketplace, $product),
            'raw' => [
                'margin' => $calculatedPrice->getMargin(),
                'profit' => $this->transformMoney($calculatedPrice->getProfit()),
            ],
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
