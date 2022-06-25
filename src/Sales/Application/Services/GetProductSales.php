<?php

namespace Src\Sales\Application\Services;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;
use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Application\Data\MarketplaceSaleItems;
use Src\Sales\Application\Data\Reports\SaleItemsInMarketplaces;
use Src\Sales\Application\Data\SaleItemsCollection;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Services\Contracts\GetProductSales as GetProductSalesInterface;

class GetProductSales implements GetProductSalesInterface
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function getLastSaleItems(Product $product, int $limit = 5): SaleItemsCollection
    {
        $sales = $product->getSaleItems();

        $sales = $sales->sortByDesc(function (Item $saleItem) {
            return $saleItem->getSelledAt();
        })->take($limit);

        return new SaleItemsCollection($sales);
    }

    public function getSaleItemsInAllMarketplaces(Product $product): SaleItemsInMarketplaces
    {
        $marketplaces = $this->marketplaceRepository->list();

        $salesInMarketplaces = $marketplaces->map(function (Marketplace $marketplace) use ($product) {
            $sales = $this->getSaleItemsByMarketplace($product, $marketplace);

            return $sales;
        });

        return new SaleItemsInMarketplaces($salesInMarketplaces);
    }

    public function getSaleItemsByMarketplace(Product $product, Marketplace $marketplace): MarketplaceSaleItems
    {
        $sales = $product->getSaleItems();

        $sales = $sales->filter(function (Item $saleItem) use ($marketplace) {
            if (!$saleOrder = $saleItem->getSaleOrder()) {
                return false;
            }

            $slug = $saleOrder->getMarketplace()?->getSlug() ?? '';

            return $marketplace->getSlug() === $slug;
        });

        return new MarketplaceSaleItems(
            $marketplace,
            new SaleItemsCollection($sales)
        );
    }

    public function getTotalSaleItems(Product $product): SaleItemsCollection
    {
        return new SaleItemsCollection($product->getSaleItems());
    }
}
