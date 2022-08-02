<?php

namespace Src\Marketplaces\Domain\Models\Freight;

class Freight
{
    public function __construct(
        public readonly float         $defaultValue = 0.0,
        public readonly float         $minimumFreightTableValue = 0.0,
        public readonly ?FreightTable $freightTable = null
    )
    {
    }

    public function getFromTable(float $cubicWeight): float
    {
        $items = $this->freightTable?->get() ?? [];

        /**
         * @var FreightTableComponent $item
         */
        foreach ($items as $item) {
            if (
                $cubicWeight >= $item->initialCubicWeight
                && $cubicWeight < $item->endCubicWeight
            ) {
                return $item->value;
            }
        }

        return 0.0;
    }
}
