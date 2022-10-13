<?php

namespace Src\Sales\Domain\DataTransfer\Reports\Products;

use Illuminate\Support\Collection;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;

/**
 * @deprecated
 */
class SalesInMarketplaces
{
    public readonly Collection $marketplacesSales;

    public function __construct(Collection $marketplacesSales)
    {
        $this->marketplacesSales = $marketplacesSales->map(function (MarketplaceSales $marketplaceSales) {
            return $marketplaceSales;
        });
    }
}
