<?php

namespace Src\Sales\Application\Data;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Sales\Domain\Models\SaleOrder;

class MarketplaceSales
{
    public readonly Marketplace $marketplace;
    public readonly Collection $sales;

    public function __construct(
        Marketplace $marketplace,
        Collection $sales,
    )
    {
        $this->marketplace = $marketplace;

        $this->sales = $sales->map(function (SaleOrder $saleOrder) {
            return $saleOrder;
        });
    }
}
