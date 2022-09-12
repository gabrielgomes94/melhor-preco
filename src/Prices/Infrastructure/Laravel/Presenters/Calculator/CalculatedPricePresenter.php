<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Math\Percentage;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class CalculatedPricePresenter
{
    public function __construct(
        private readonly CommissionRepository $commissionRepository
    )
    {}

    public function present(
        PriceCalculatedFromProduct $priceCalculatedFromProduct,
        ?CalculatorForm $form = null
    ): array
    {
        $calculatedPrice = $priceCalculatedFromProduct->calculatedPrice;
        $marketplace = $priceCalculatedFromProduct->marketplace;
        $product = $priceCalculatedFromProduct->product;

        return [
            'formatted' => $this->format($calculatedPrice, $marketplace, $product, $form),
            'raw' => [
                'margin' => round($calculatedPrice->getMargin(), 2),
                'profit' => round($calculatedPrice->getProfit(), 2),
            ],
        ];
    }

    private function format(
        CalculatedPrice $calculatedPrice,
        Marketplace $marketplace,
        Product $product,
        ?CalculatorForm $form
    ): array
    {
        $commissionRate = $form?->commission
            ? $form->commission->get()
            : $this->commissionRepository->getCommissionRate($marketplace, $product)->get();

        return [
            'commission' => MathPresenter::money($calculatedPrice->getCommission()),
            'commissionRate' => $commissionRate,
            'costs' => MathPresenter::money($calculatedPrice->getCosts()),
            'differenceICMS' => MathPresenter::money($calculatedPrice->getDifferenceICMS()),
            'freight' => MathPresenter::money($calculatedPrice->getFreight()),
            'marketplaceSlug' => $marketplace->getSlug(),
            'margin' => MathPresenter::percentage(
                Percentage::fromPercentage($calculatedPrice->getMargin())
            ),
            'profit' => MathPresenter::money($calculatedPrice->getProfit()),
            'purchasePrice' => MathPresenter::money($calculatedPrice->getPurchasePrice()),
            'suggestedPrice' => MathPresenter::money($calculatedPrice->get()),
            'taxSimplesNacional' => MathPresenter::money($calculatedPrice->getSimplesNacional()),
        ];
    }
}
