<?php

namespace Src\Sales\Application\Data;

use Src\Marketplaces\Domain\Models\Marketplace;

class MarketplaceSaleItems
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly SaleItemsCollection $sales,
    ){}
}
