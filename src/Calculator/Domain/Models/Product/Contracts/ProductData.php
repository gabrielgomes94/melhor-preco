<?php

namespace Src\Calculator\Domain\Models\Product\Contracts;

use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Models\Product\Data\Costs;
use Src\Products\Domain\Models\Product\Data\Dimensions;

interface ProductData
{
    public function getCategory(): ?Category;

    public function getCosts(): Costs;

    public function getDimensions(): Dimensions;
}
