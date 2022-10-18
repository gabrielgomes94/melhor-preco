<?php

namespace Src\Sales\Application\Repositories;

use Carbon\Carbon;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Domain\Models\Product;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Application\Repositories\Queries\SalesQuery;

class MarketplaceSalesRepository
{
    public function __construct(
        private ProductSalesRepository $productSalesRepository,
        private readonly SalesQuery $salesQuery
    )
    {}

    public function getSales(
        Marketplace $marketplace,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): MarketplaceSales
    {
        $query = $this->salesQuery->salesInInterval($beginDate, $endDate);
        $saleItems = new SaleItemsCollection(
            $query->where('store_id', $marketplace->getErpId())
                ->get()
                ->toArray()
        );

        return new MarketplaceSales($marketplace, $saleItems);
    }

    public function getSalesByProduct(
        Product $product,
        Marketplace $marketplace,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): MarketplaceSales
    {
        $beginDate = $beginDate ?? Carbon::create(1900);
        $endDate = $endDate ?? Carbon::create(9999);

        $itemsSelled = $this->productSalesRepository->getItemsSelled($product, $beginDate, $endDate);
        $itemsSelled = collect($itemsSelled);
        $itemsSelled = $itemsSelled->filter(function (Item $saleItem) use ($marketplace) {
            if (!$saleOrder = $saleItem->getSaleOrder()) {
                return false;
            }

            $slug = $saleOrder->getMarketplace()?->getSlug() ?? '';

            return $marketplace->getSlug() === $slug;
        });

        return new MarketplaceSales(
            $marketplace,
            new SaleItemsCollection($itemsSelled->toArray())
        );
    }
}
