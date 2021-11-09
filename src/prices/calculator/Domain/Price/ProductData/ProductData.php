<?php

namespace Src\Prices\Calculator\Domain\Price\ProductData;

use Src\Prices\Calculator\Domain\Contracts\Models\ProductData as ProductDataInterface;
use Src\Products\Domain\Product\Contracts\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Contracts\Models\Data\Dimensions\Dimensions;
use Src\Products\Domain\Product\Models\Data\Costs\Factory as CostsFactory;
use Src\Products\Domain\Product\Models\Data\Dimensions\Factory as DimensionsFactory;
use Src\Products\Domain\Product\Models\Product;


class ProductData implements ProductDataInterface
{
    private Costs $costs;
    private Dimensions $dimensions;

    public function __construct(Costs $costs, Dimensions $dimensions)
    {
        $this->costs = $costs;
        $this->dimensions = $dimensions;
    }

    public static function fromModel(Product $product): self
    {
        return new self(
            CostsFactory::make($product),
            DimensionsFactory::make($product)
        );
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
