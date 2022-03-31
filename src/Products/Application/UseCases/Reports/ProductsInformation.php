<?php

namespace Src\Products\Application\UseCases\Reports;

use Carbon\Carbon;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Application\UseCases\Filters\ListSalesFilter;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository as SaleRepository;

class ProductsInformation
{
    public function __construct (
        private ProductRepository $productRepository,
        private MarketplaceRepository $marketplaceRepository,
        private ItemsRepository $saleItemsRepository
    ) {}

    public function report(): array
    {
        $products = $this->productRepository->all();
        $products = $products->map(function (Product $product) {

            $magaluMarketplace = $this->marketplaceRepository->getBySlug('magalu');
            $mercadoLivreMarketplace = $this->marketplaceRepository->getBySlug('mercado-livre');
            $shopeeMarketplace =  $this->marketplaceRepository->getBySlug('shopee');

            return [
                'sku' => $product->getIdentifiers()->getSku(),
                'name' => $product->getDetails()->getName(),
                'checklist' => [
                    'postedOnMagalu' => $product->postedOnMarketplace($magaluMarketplace),
                    'postedOnMercadoLivre' => $product->postedOnMarketplace($mercadoLivreMarketplace),
                    'postedOnShopee' => $product->postedOnMarketplace($shopeeMarketplace),
                    'hasManyImages' => count($product->getImages()) >= 3,
                ],
                'sales' => $this->saleItemsRepository->countSalesByProduct(
                    $product,
                    new ListSalesFilter([
                        'beginDate' => '01/01/2022',
                        'endDate' => '31/03/2022',
                    ])
                ),
            ];
        })->toArray();

        return $products;
    }
}
