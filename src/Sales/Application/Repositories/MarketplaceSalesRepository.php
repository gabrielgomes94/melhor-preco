<?php

namespace Src\Sales\Application\Repositories;

use Carbon\Carbon;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Domain\Models\Product;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Domain\Repositories\MarketplaceSalesRepository as MarketplaceSalesRepositoryInterface;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Application\Repositories\Queries\SalesQuery;

class MarketplaceSalesRepository implements MarketplaceSalesRepositoryInterface
{
    public function __construct(
        private readonly ProductSalesRepository $productSalesRepository,
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

        $sales = new SaleOrdersCollection(
            $query->where('store_id', $marketplace->getErpId())
                ->get()
                ->all()
        );

        return new MarketplaceSales($marketplace, $sales);
    }

    public function getSalesByProduct(
        Product $product,
        Marketplace $marketplace,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): MarketplaceSales
    {
        $itemsSelled = $this->productSalesRepository->getItemsSelled($product, $beginDate, $endDate);

        $itemsSelled = collect($itemsSelled);
        $itemsSelled = $itemsSelled->filter(function (Item $saleItem) use ($marketplace) {
            if (!$saleOrder = $saleItem->getSaleOrder()) {
                return false;
            }

            $slug = $saleOrder->getMarketplace()?->getSlug() ?? '';

            return $marketplace->getSlug() === $slug;
        });

        $saleOrders = $itemsSelled->map(
            fn (Item $item) => $item->getSaleOrder()
        );

        return new MarketplaceSales(
            $marketplace,
            new SaleOrdersCollection($saleOrders->all())
        );
    }
}
