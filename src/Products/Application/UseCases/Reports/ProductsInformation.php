<?php

namespace Src\Products\Application\UseCases\Reports;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Application\Data\FilterOptions;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;

class ProductsInformation
{
    public function __construct(
        private ProductRepository $productRepository,
        private MarketplaceRepository $marketplaceRepository,
        private ItemsRepository $saleItemsRepository
    ) {
    }

    public function report(FilterOptions $filter): array
    {
        $productsPaginator = $this->getProducts($filter);

        $products = collect($productsPaginator->items());
        $products = $products->map(function (Product $product) {
            return [
                'sku' => $product->getIdentifiers()->getSku(),
                'name' => $product->getDetails()->getName(),
                'checklist' => [
                    'postedOnMagalu' => $this->isProductPostedOn($product, 'magalu'),
                    'postedOnMercadoLivre' => $this->isProductPostedOn($product, 'mercado-livre'),
                    'postedOnShopee' => $this->isProductPostedOn($product, 'shopee'),
                    'hasManyImages' => count($product->getImages()) >= 3,
                ],
                'sales' => $this->saleItemsRepository->countSalesByProduct(
                    $product,
                    $filter->beginDate ?? Carbon::createFromFormat('d/m/Y', '01/01/2020'),
                    $filter->endDate ?? Carbon::now()
                ),
            ];
        })->toArray();

        return [
            'data' => $products,
            'paginator' => $productsPaginator,
        ];
    }

    private function isProductPostedOn(Product $product, string $slug): bool
    {
        $marketplace = $this->marketplaceRepository->getBySlug($slug);

        return $product->postedOnMarketplace($marketplace);
    }

    private function getProducts(FilterOptions $filter): LengthAwarePaginator
    {
        return $this->productRepository->allFiltered($filter);
    }
}
