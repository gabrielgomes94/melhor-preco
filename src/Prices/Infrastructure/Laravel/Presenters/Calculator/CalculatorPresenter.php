<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Src\Costs\Domain\Models\PurchaseItem;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class CalculatorPresenter
{
    public function __construct(
        private readonly CalculatedPricePresenter $pricePresenter,
        private readonly ProductPresenter $productPresenter,
        private readonly CommissionRepository $commissionRepository,
        private readonly PurchaseItemsPresenter $purchaseItemsPresenter
    ) {
    }

    public function present(
        PriceCalculatedFromProduct $priceCalculatedFromProduct,
        ?CalculatorForm $form = null,
    ): array
    {
        $product = $priceCalculatedFromProduct->product;
        $marketplace = $priceCalculatedFromProduct->marketplace;
        $calculatedPrice = $priceCalculatedFromProduct->calculatedPrice;

        return [
            'calculatorForm' => $this->getCalculatorForm($marketplace, $product, $calculatedPrice, $form),
            'calculatedPrice' => $this->pricePresenter->present($priceCalculatedFromProduct, $form),
            'productInfo' => $this->productPresenter->present($marketplace, $product),
            'costsForm' => $this->getCostsForm($product),
            'priceId' => $product->getPrice($marketplace)->getId(),
            'marketplacesList' => $this->getMarketplacesList($marketplace, $product),
            'costs' => $this->getCosts($product),
        ];
    }

    private function getCalculatorForm(
        Marketplace $marketplace,
        Product $product,
        CalculatedPrice $calculatedPrice,
        ?CalculatorForm $form = null
    ): array
    {
        $commission = $this->commissionRepository->getCommissionRate($marketplace, $product);

        $presented = [
            'marketplaceName' => $marketplace->getName(),
            'marketplaceSlug' => $marketplace->getSlug(),
            'commission' => $commission->get(),
            'discount' => 0.0,
            'desiredPrice' => $calculatedPrice->get(),
            'productId' => $product->getSku(),
            'freight' => $calculatedPrice->getFreight(),
        ];

        if (!$form) {
            return $presented;
        }

        return array_replace_recursive(
            $presented,
            [
                'discount' => $form->discount?->get() ?? 0.0,
                'desiredPrice' => $form->desiredPrice,
                'commission' => $form->commission?->get() ?? 0.0,
                'freight' => $form->freight ?? $presented['freight'],
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

    private function getCosts(Product $product): array
    {
        $costs = $product?->getLastPurchaseItemsCosts();

        return $costs instanceof PurchaseItem
            ? [$this->purchaseItemsPresenter->present($costs)]
            : [];
    }
}
