<?php

namespace Src\Sales\Domain\DataTransfer\Reports;

use Illuminate\Support\Collection;
use Src\Sales\Domain\DataTransfer\MarketplaceSaleItems;

class SaleItemsInMarketplaces
{
    public readonly Collection $marketplacesSales;

    public function __construct(Collection $marketplacesSales)
    {
        $this->marketplacesSales = $marketplacesSales->map(function (MarketplaceSaleItems $marketplaceSales) {
            return $marketplaceSales;
        });
    }
}
