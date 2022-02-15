<?php

namespace Src\Sales\Application\UseCases\Reports;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Application\Data\SaleItemsCollection;
use Src\Sales\Domain\Models\Contracts\SaleOrder;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Services\Contracts\GetProductSales;

class ReportProductSales
{
    public function __construct(
        private ProductRepository $repository,
        private GetProductSales $getProductSales
    ) {}

    public function report(string $sku): array
    {
        $product = $this->getProduct($sku);

        return [
            'total' => $this->getProductSales->getTotalSales($product),
            'salesByMarketplace' => $this->getProductSales->getSalesInAllMarketplaces($product),
            'lastSales' => $this->getProductSales->getLastSales($product),
        ];
    }

//    private function getMarketplaces(\Src\Products\Domain\Models\Product\Contracts\Product $product): Collection
//    {
//        $marketplaces = $this->marketplaceRepository->list();
//
//        return $marketplaces->map(function(Marketplace $marketplace) use ($product) {
//            $sales = $this->getProductSales->getSalesByMarketplace($product, $marketplace);
//
//            return $sales;
////            return [
////                'quantity' => $sales->count(),
////                'value' => $sales->sum(function(Item $saleItem) {
////                    return $saleItem->getTotalValue();
////                }),
////                'slug' => $marketplaceSlug,
////                'storeName' => $marketplace->getName(),
////            ];
//        });
//    }

//    private function presentLastSales(Collection $sales): array
//    {
//        return $sales->map(function(Item $saleItem) {
//            return [
//                'marketplace' => $saleItem->getMarketplace(),
//                'value' => $saleItem->getTotalValue(),
//                'selledAt' => $saleItem->getSelledAt(),
//            ];
//        })->take(5)->toArray();
//    }
    private function getProduct(string $sku): Product
    {
        $product = $this->repository->get($sku);

        if (!$product) {
            throw new ProductNotFoundException($sku);
        }

        return $product;
    }
}
