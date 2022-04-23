<?php

namespace Src\Prices\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;

class ProductPresenter
{
    public function __construct(
        private Breadcrumb $breadcrumb,
        private PricePresenter $pricePresenter,
        private MarketplaceRepository $marketplaceRepository,
        private \Src\Calculator\Presentation\Presenters\PricePresenter $calculatorPresenter
    ) {
    }

    public function present(array $data): array
    {
        $product = $data['product'];
        $post = $data['post'];

        $marketplace = $post->getMarketplace();
        $marketplaces = $this->marketplaceRepository->list();

        return [
            'breadcrumb' => $this->getBreadcrumb($marketplace, $product),
            'calculatorForm' => $this->getCalculatorForm($product, $post, $marketplace),
            'store' => $marketplace,
            'price' => $this->pricePresenter->present($product, $post),
            'product' => $product,
            'productId' => $product->getSku(),
            'productHeader' => $this->getProductHeader($product),
            'marketplaces' => $marketplaces,
            'isFreeFreightDisabled' => $this->isFreeFreightDisabled($marketplace)
        ];
    }

    public function presentNew(Product $product, Post $post)
    {
//        $product = $data['product'];
//        $post = $data['post'];

        $marketplace = $post->getMarketplace();

        return [
            'breadcrumb' => $this->getBreadcrumb($marketplace, $product),
            'calculatorForm' => $this->getCalculatorForm($post),
            'productInfo' => $this->getProductInfo($product),
            'costsForm' => $this->getCostsForm($product),
            'price' => $this->getPrice($post),
            'navbar' => $this->getNavbar($marketplace),
        ];
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
            'discount' => 5.0,
            'desiredPrice' => MoneyTransformer::toFloat($price->get()),
            'isFreeFreightDisabled' => $this->isFreeFreightDisabled($marketplace),
            'priceId' => $post->getId(),
            'productId' => $post->getProduct()->getSku(),
        ];
    }

    private function getProductInfo(Product $product): array
    {
        return [
            'product' => $product,
            'id' => $product->getSku(),
            'header' => $this->getProductHeader($product),
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
        return $this->calculatorPresenter->transform($post);
    }

    private function getNavbar(Marketplace $marketplace): array
    {
        return [
            'marketplaces' => $this->marketplaceRepository->list(),
            'selected' => $marketplace->getSlug(),
        ];
    }
}
