<?php

namespace Src\Calculator\Domain\Models\Product;

use Src\Calculator\Domain\Models\Product\Contracts\ProductData as ProductDataInterface;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Costs\Factory as CostsFactory;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;
use Src\Products\Domain\Models\Product\Data\Dimensions\Factory as DimensionsFactory;
use Src\Products\Domain\Models\Product\Product;

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

    public static function fromArray(array $data): self
    {
        if (!$data['costs'] instanceof Costs) {
            throw new \Exception('Invalid costs attribute type');
        }

        if (!$data['dimensions'] instanceof Dimensions) {
            throw new \Exception('Invalid dimensions attribute type');
        }

        return new self($data['costs'], $data['dimensions']);
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
