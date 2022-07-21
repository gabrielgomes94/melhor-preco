<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Http\Requests\CalculatePriceRequest;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class ProductPresenter
{
    public function __construct(
        private Breadcrumb $breadcrumb,
        private MarketplaceRepository $marketplaceRepository,
        private PricePresenter $calculatorPresenter,
        private CommissionRepository $commissionRepository,
        private ProductRepository $productRepository,
    ) {
    }


    public function present(string $marketplaceSlug, string $productSku, string $userId, CalculatedPrice $calculatedPrice, CalculatePriceRequest $request)
    {
        $product = $this->productRepository->get($productSku, $userId);
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);

        $presentedData = [
            'breadcrumb' => $this->getBreadcrumb($marketplace, $product),
            'calculatorForm' => $this->getCalculatorForm($marketplace, $product, $calculatedPrice),
            'productInfo' => $this->getProductInfo($marketplace, $product),
            'costsForm' => $this->getCostsForm($product),
            'calculatedPrice' => $this->getPrice($calculatedPrice, $marketplace, $product),
            'navbar' => $this->getNavbar($marketplace, $product->getUser()->getId()),
            'marketplacesList' => $this->getMarketplacesList($marketplace, $product),
        ];

        return $this->mergeRequest($presentedData, $request);
    }

    private function mergeRequest(array $presentedData, CalculatePriceRequest $request): array
    {
        return array_replace_recursive(
            $presentedData,
            [
                'calculatorForm' => [
                    'discount' => (float) ($request->validated()['discount'] ?? 0.0),
                    'desiredPrice' => (float) ($request->validated()['price'] ?? 0.0),
                ]
            ]
        );
    }

    private function getBreadcrumb(Marketplace $marketplace, Product $product)
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($marketplace->getName(), $marketplace->getSlug()),
            Breadcrumb::product($product->getDetails()->getName()),
        );
    }

    private function getProductHeader(Product $product): string
    {
        return $product->getSku() . ' - ' . $product->getDetails()->getName();
    }

    // @todo: melhorar essa lógica. Talvez jogar isso aqui pra camada de domínio.
    private function isFreeFreightDisabled(Marketplace $marketplace): bool
    {
        $marketplaceSlug = $marketplace->getSlug();

        if (in_array($marketplaceSlug, ['magalu', 'shopee'])) {
            return true;
        }

        return false;
    }

    private function getCalculatorForm(Marketplace $marketplace, Product $product, CalculatedPrice $calculatedPrice): array
    {
        $commission = $this->commissionRepository->get($marketplace, $product);

        return [
            'marketplaceName' => $marketplace->getName(),
            'marketplaceSlug' => $marketplace->getSlug(),
            'commission' => $commission->get(),
            'desiredPrice' => MoneyTransformer::toFloat($calculatedPrice->get()),
            'isFreeFreightDisabled' => $this->isFreeFreightDisabled($marketplace),
            'priceId' => $product->getPrice($marketplace)->getId(),
            'productId' => $product->getSku(),
        ];
    }

    private function getProductInfo(Marketplace $marketplace, Product $product): array
    {
        return [
            'product' => $product,
            'id' => $product->getSku(),
            'header' => $this->getProductHeader($product),
            'currentPrice' => MathPresenter::money($product->getPrice($marketplace)->getValue()),
        ];
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

    private function getPrice(CalculatedPrice $calculatedPrice, Marketplace $marketplace, Product $product): array
    {
        return [
            'raw' => $this->calculatorPresenter->transformRaw($calculatedPrice, $marketplace, $product),
            'formatted' => $this->calculatorPresenter->format($calculatedPrice, $marketplace, $product)
        ];
    }

    private function getNavbar(Marketplace $marketplace, string $userId): array
    {
        return [
            'marketplaces' => $this->marketplaceRepository->list($userId),
            'selected' => $marketplace->getSlug(),
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
