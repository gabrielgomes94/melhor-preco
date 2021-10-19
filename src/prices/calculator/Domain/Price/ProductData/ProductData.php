<?php

namespace Src\Prices\Calculator\Domain\Price\ProductData;

use Src\Prices\Calculator\Domain\Contracts\Models\ProductData as ProductDataInterface;
use Src\Products\Domain\Product\Contracts\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Contracts\Models\Data\Dimensions\Dimensions;

//use Src\Products\Domain\Product\Models\Data\Costs\Costs;
//use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;

class ProductData implements ProductDataInterface
{
    private Costs $costs;
    private Dimensions $dimensions;

    public function __construct(Costs $costs, Dimensions $dimensions)
    {
        $this->costs = $costs;
        $this->dimensions = $dimensions;
    }

    public function getCosts(): Costs
    {
        return $this->costs;
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }
}
