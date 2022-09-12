<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Math\Transformers\NumberTransformer;
use Src\Math\Transformers\MoneyTransformer;
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
            'commission' => NumberTransformer::toMoney($calculatedPrice->getCommission()),
            'commissionRate' => $commissionRate,
            'costs' => NumberTransformer::toMoney($calculatedPrice->getCosts()),
            'differenceICMS' => NumberTransformer::toMoney($calculatedPrice->getDifferenceICMS()),
            'freight' => NumberTransformer::toMoney($calculatedPrice->getFreight()),
            'marketplaceSlug' => $marketplace->getSlug(),
            'margin' => NumberTransformer::toPercentage(
                Percentage::fromPercentage($calculatedPrice->getMargin())
            ),
            'profit' => NumberTransformer::toMoney($calculatedPrice->getProfit()),
            'purchasePrice' => NumberTransformer::toMoney($calculatedPrice->getPurchasePrice()),
            'suggestedPrice' => NumberTransformer::toMoney($calculatedPrice->get()),
            'taxSimplesNacional' => NumberTransformer::toMoney($calculatedPrice->getSimplesNacional()),
        ];
    }
}
