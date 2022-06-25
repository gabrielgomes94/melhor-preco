<?php

namespace Src\Prices\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Src\Calculator\Presentation\Http\Requests\CalculatePriceRequest;
use Src\Calculator\Presentation\Presenters\PricePresenter;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Post\Contracts\Post;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class ProductPresenter
{
    public function __construct(
        private Breadcrumb $breadcrumb,
        private MarketplaceRepository $marketplaceRepository,
        private PricePresenter $calculatorPresenter
    ) {
    }

    public function present(Post $post, CalculatePriceRequest $request)
    {
        $marketplace = $post->getMarketplace();
        $product = $post->getProduct();

        $presentedData = [
            'breadcrumb' => $this->getBreadcrumb($marketplace, $product),
            'calculatorForm' => $this->getCalculatorForm($post),
            'productInfo' => $this->getProductInfo($post),
            'costsForm' => $this->getCostsForm($product),
            'calculatedPrice' => $this->getPrice($post),
            'navbar' => $this->getNavbar($marketplace),
            'marketplacesList' => $this->getMarketplacesList($post),
        ];

        return $this->mergeRequest($presentedData, $request);
    }

    private function mergeRequest(array $presentedData, CalculatePriceRequest $request): array
    {
        return array_replace_recursive(
            $presentedData,
            [
                'calculatorForm' => [
                    'discount' => (float) ($request->transform()['discount'] ?? 0.0),
                    'desiredPrice' => (float) ($request->transform()['price'] ?? 0.0),
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

    private function getCalculatorForm(Post $post): array
    {
        $price = $post->getCalculatedPrice();
        $commissionRate = $price->getCommission()->getCommissionRate();
        $commission = Percentage::fromFraction($commissionRate)->get();
        $marketplace = $post->getMarketplace();

        return [
            'marketplaceName' => $marketplace->getName(),
            'marketplaceSlug' => $marketplace->getSlug(),
            'commission' => $commission,
            'desiredPrice' => MoneyTransformer::toFloat($price->get()),
            'isFreeFreightDisabled' => $this->isFreeFreightDisabled($marketplace),
            'priceId' => $post->getId(),
            'productId' => $post->getProduct()->getSku(),
        ];
    }

    private function getProductInfo(Post $post): array
    {
        $product = $post->getProduct();

        return [
            'product' => $product,
            'id' => $product->getSku(),
            'header' => $this->getProductHeader($product),
            'currentPrice' => MathPresenter::money($post->getPrice()->getValue()),
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

    private function getPrice(Post $post): array
    {
        return [
            'raw' => $this->calculatorPresenter->transformRaw($post),
            'formatted' => $this->calculatorPresenter->format($post)
        ];
    }

    private function getNavbar(Marketplace $marketplace): array
    {
        return [
            'marketplaces' => $this->marketplaceRepository->list(),
            'selected' => $marketplace->getSlug(),
        ];
    }

    private function getMarketplacesList(Post $post): array
    {
        $product = $post->getProduct();
        $prices = $product->getPrices();
        $currentMarketplaceSlug = $post->getMarketplace()->getSlug();

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
