<?php

namespace Src\Sales\Application\Data;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;

class MarketplaceSaleItems
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly SaleItemsCollection $sales,
    ){}
}
