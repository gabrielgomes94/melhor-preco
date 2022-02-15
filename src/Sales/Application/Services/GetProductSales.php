<?php

namespace Src\Sales\Application\Services;

use Illuminate\Support\Collection;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Sales\Application\Data\MarketplaceSales;
use Src\Sales\Application\Data\SaleItemsCollection;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Services\Contracts\GetProductSales as GetProductSalesInterface;

class GetProductSales implements GetProductSalesInterface
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository
    ){}

    public function getLastSales(Product $product, int $limit = 5): Collection
    {
        $sales = $product->getSaleItems();

        return $sales->sortByDesc(function (Item $saleItem) {
            return $saleItem->getSelledAt();
        })->take($limit);
    }

    public function getSalesInAllMarketplaces(Product $product): Collection
    {
        $marketplaces = $this->marketplaceRepository->list();

        return $marketplaces->map(function(\Src\Marketplaces\Domain\Models\Contracts\Marketplace $marketplace) use ($product) {
            $sales = $this->getSalesByMarketplace($product, $marketplace);

            return $sales;
        });
    }


    public function getSalesByMarketplace(Product $product, Marketplace $marketplace): MarketplaceSales
    {
        $sales = $product->getSaleItems();

        $sales = $sales->filter(function (Item $saleItem) use ($marketplace) {
            if (!$saleOrder = $saleItem->getSaleOrder()) {
                return false;
            }

            $slug = $saleOrder->getMarketplace()?->getSlug() ?? '';

            return $marketplace->getSlug() === $slug;
        })->map(function(Item $saleItem) {
            return $saleItem->getSaleOrder();
        });

        return new MarketplaceSales(
            $marketplace,
            $sales
        );
    }

    public function getTotalSales(Product $product): SaleItemsCollection
    {
        return new SaleItemsCollection($product->getSaleItems());
    }
}
