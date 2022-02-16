<?php

namespace Src\Sales\Application\Data\Reports;

use Illuminate\Support\Collection;
use Src\Sales\Application\Data\MarketplaceSaleItems;

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
