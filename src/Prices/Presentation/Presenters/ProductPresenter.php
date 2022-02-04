<?php

namespace Src\Prices\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Models\Product\Product;

class ProductPresenter
{
    private Breadcrumb $breadcrumb;
    private PricePresenter $pricePresenter;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(
        Breadcrumb $breadcrumb,
        PricePresenter $pricePresenter,
        MarketplaceRepository $marketplaceRepository
    ) {
        $this->breadcrumb = $breadcrumb;
        $this->pricePresenter = $pricePresenter;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function present(array $data): array
    {
        $product = $data['product'];
        $post = $data['post'];

        $marketplace = $post->getMarketplace();
        $marketplaces = $this->marketplaceRepository->list();

        return [
            'breadcrumb' => $this->getBreadcrumb($marketplace, $product),
            'store' => $marketplace,
            'price' => $this->pricePresenter->present($product, $post),
            'product' => $product,
            'productId' => $product->getSku(),
            'productHeader' => $this->getProductHeader($product),
            'marketplaces' => $marketplaces,
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
        return $product->getSku() . '-' . $product->getDetails()->getName();
    }
}
