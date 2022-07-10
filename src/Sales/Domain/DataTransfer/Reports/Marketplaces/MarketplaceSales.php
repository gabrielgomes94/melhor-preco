<?php

namespace Src\Sales\Domain\DataTransfer\Reports\Marketplaces;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Sales\Domain\DataTransfer\SaleItemsCollection;

class MarketplaceSales
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly SaleItemsCollection $sales,
    ){}
}
