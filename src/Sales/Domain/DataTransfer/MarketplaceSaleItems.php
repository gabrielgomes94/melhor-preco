<?php

namespace Src\Sales\Domain\DataTransfer;

use Src\Marketplaces\Domain\Models\Marketplace;

class MarketplaceSaleItems
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly SaleItemsCollection $sales,
    ){}
}
