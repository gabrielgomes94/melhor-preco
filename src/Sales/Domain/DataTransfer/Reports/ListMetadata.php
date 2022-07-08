<?php

namespace Src\Sales\Domain\DataTransfer\Reports;

class ListMetadata
{
    public function __construct(
        public readonly int $salesCount,
        public readonly int $productsCount,
        public readonly array $marketplacesCount,
        public readonly float $totalValue,
        public readonly float $totalProfit
    )
    {
    }
}
