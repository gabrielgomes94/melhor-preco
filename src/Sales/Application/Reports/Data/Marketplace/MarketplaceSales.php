<?php

namespace Src\Sales\Application\Reports\Data\Marketplace;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

/**
 * @todo: usar SaleOrdersCollection ao invés de SaleItemsCollection
 */
class MarketplaceSales
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly SaleItemsCollection $sales,
    ) {
    }

    public function getTotalValue(): float
    {
        $sales = collect($this->sales->get());

        return $sales->sum(function (Item $saleItem) {
            return $saleItem->getTotalValue();
        });
    }

    public function getSalesCount(): int
    {
        $sales = collect($this->sales->get());

        return $sales->count();
    }
}
