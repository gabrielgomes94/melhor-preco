<?php

namespace Src\Sales\Application\Reports\Data\Marketplace;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

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

        return $sales->sum(
            fn (SaleOrder $saleOrder) => $saleOrder->getSaleValue()->totalValue()
        );
    }

    public function getSalesCount(): int
    {
        $sales = collect($this->sales->get());

        return $sales->count();
    }
}
