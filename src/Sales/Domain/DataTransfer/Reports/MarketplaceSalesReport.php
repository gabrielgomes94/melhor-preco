<?php

namespace Src\Sales\Domain\DataTransfer\Reports;

use Src\Marketplaces\Domain\Models\Marketplace;

class MarketplaceSalesReport
{
    public function __construct(
        public readonly Marketplace $marketplace,
        public readonly int $salesCount
    )
    {
    }
}
