<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListMetadata;
use Src\Sales\Domain\Models\SaleOrder;

class MetadataSales
{
    public function __construct(
        private readonly MarketplacesSalesCount $marketplaceSalesCount
    )
    {
    }

    public function report(ListSalesFilter $options): ListMetadata
    {
        $salesQuery = SaleOrder::valid()
            ->inDateInterval($options->getBeginDate(), $options->getEndDate())
            ->defaultOrder();

        $salesCollection = $salesQuery->get();
        $productsCount = $salesCollection->sum(
            function(SaleOrder $saleOrder) {
                return $saleOrder->items->count();
            });

        $marketplacesCount = $this->marketplaceSalesCount->report($options);

        return new ListMetadata(
            $salesCollection->count(),
            $productsCount,
            $marketplacesCount,
            $salesCollection->sum('total_value'),
            $salesCollection->sum('total_profit')
        );
    }
}
