<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports\Factories;

use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListMetadata;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\Factories\MarketplacesSalesFactory;

class SalesMetadataFactory
{
    public function __construct(
        private readonly MarketplacesSalesFactory $marketplaceSalesCount
    )
    {
    }

    public function report(SalesFilter $options): ListMetadata
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
