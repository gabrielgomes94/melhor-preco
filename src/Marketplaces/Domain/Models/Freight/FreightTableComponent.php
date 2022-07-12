<?php

namespace Src\Marketplaces\Domain\Models\Freight;

class FreightTableComponent
{
    const INFINITY = 999999;

    public function __construct(
        public readonly float $value,
        public readonly float $initialCubicWeight = 0.0,
        public readonly float $endCubicWeight = self::INFINITY
    )
    {
    }
}
