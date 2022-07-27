<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use App\Http\Controllers\Utils\Breadcrumb;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Http\Requests\CalculatePriceRequest;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Presenters\Calculator\CalculatedPricePresenter;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class CalculatorPresenter
{
    public function __construct(
        private CalculatedPricePresenter $pricePresenter,
        private ProductPresenter $productPresenter,
        private CommissionRepository $commissionRepository,
    ) {
    }

    public function present(
        PriceCalculatedFromProduct $priceCalculatedFromProduct,
        CalculatePriceRequest $request
    ): array
    {
        $product = $priceCalculatedFromProduct->product;
        $marketplace = $priceCalculatedFromProduct->marketplace;
        $calculatedPrice = $priceCalculatedFromProduct->calculatedPrice;

        return [
            'calculatorForm' => $this->getCalculatorForm($marketplace, $product, $calculatedPrice, $request),
            'calculatedPrice' => $this->pricePresenter->present($calculatedPrice, $marketplace, $product),
            'productInfo' => $this->productPresenter->present($marketplace, $product),
            'costsForm' => $this->getCostsForm($product),
            'marketplacesList' => $this->getMarketplacesList($marketplace, $product),
        ];
    }

    private function getCalculatorForm(
        Marketplace $marketplace,
        Product $product,
        CalculatedPrice $calculatedPrice,
        CalculatePriceRequest $request
    ): array
    {
        $commission = $this->commissionRepository->get($marketplace, $product);

        $presented = [
            'marketplaceName' => $marketplace->getName(),
            'marketplaceSlug' => $marketplace->getSlug(),
            'commission' => $commission->get(),
            'discount' => 0.0,
            'desiredPrice' => MoneyTransformer::toFloat($calculatedPrice->get()),
            'priceId' => $product->getPrice($marketplace)->getId(),
            'productId' => $product->getSku(),
            'freight' => MoneyTransformer::toFloat($calculatedPrice->getFreight()),
        ];

        if (!$request->transform()) {
            return $presented;
        }

        return array_replace_recursive(
            $presented,
            [
                'discount' => (float) ($request->validated()['discount'] ?? 0.0),
                'desiredPrice' => (float) ($request->validated()['desiredPrice'] ?? 0.0),
                'commission' => (float) ($request->validated()['commission'] ?? 0.0),
                'freight' => (float) ($request->validated()['freight'] ?? $presented['freight']),
            ]
        );
    }

    private function getCostsForm(Product $product): array
    {
        $costs = $product->getCosts();

        return [
            'purchasePrice' => $costs->purchasePrice(),
            'taxICMS' => $costs->taxICMS(),
            'additionalCosts' => $costs->additionalCosts(),
        ];
    }

    private function getMarketplacesList(Marketplace $marketplace, Product $product): array
    {
        $prices = $product->getPrices();
        $currentMarketplaceSlug = $marketplace->getSlug();

        return $prices->transform(function (Price $price) use ($currentMarketplaceSlug) {
            $marketplace = $price->getMarketplace();

            return [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
                'selected' => $marketplace->getSlug() === $currentMarketplaceSlug,
            ];
        })->toArray();
    }
}
