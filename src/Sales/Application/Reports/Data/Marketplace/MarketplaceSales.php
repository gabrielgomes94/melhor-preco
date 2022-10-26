<?php

namespace Src\Sales\Application\Reports\Data\Marketplace;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Application\Models\SaleOrder;

class MarketplaceSales
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly SaleOrdersCollection $sales,
    ) {
    }

    public function getTotalValue(): float
    {
        $sales = collect($this->sales->get());

        $totalValue = $sales->sum(
            fn (SaleOrder $saleOrder) => $saleOrder->getSaleValue()->totalValue()
        );

        return round($totalValue, 2);
    }

    public function getSalesCount(): int
    {
        $sales = collect($this->sales->get());

        return $sales->count();
    }
}
