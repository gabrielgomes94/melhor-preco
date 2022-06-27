<?php

namespace Src\Calculator\Domain\Models\Product\Contracts;

use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Models\Product\ValueObjects\Dimensions;

interface ProductData
{
    public function getCategory(): ?Category;

    public function getCosts(): Costs;

    public function getDimensions(): Dimensions;
}
