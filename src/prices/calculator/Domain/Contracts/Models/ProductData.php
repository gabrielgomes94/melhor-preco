<?php

namespace Src\Prices\Calculator\Domain\Contracts\Models;

use Src\Products\Domain\Product\Contracts\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Contracts\Models\Data\Dimensions\Dimensions;

interface ProductData
{
    public function getCosts(): Costs;

    public function getDimensions(): Dimensions;
}
