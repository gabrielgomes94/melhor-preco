<?php

namespace Src\Calculator\Domain\Models\Product;

use Src\Calculator\Domain\Models\Product\Contracts\ProductData as ProductDataInterface;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Models\Product\ValueObjects\Dimensions;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class ProductData implements ProductDataInterface
{
    public readonly Costs $costs;
    public readonly Dimensions $dimensions;
    public readonly ?Category $category;

    public function __construct(Costs $costs, Dimensions $dimensions, ?Category $category)
    {
        $this->costs = $costs;
        $this->dimensions = $dimensions;
        $this->category = $category;
    }

    public static function fromArray(array $data): self
    {
        if (!$data['costs'] instanceof Costs) {
            throw new \Exception('Invalid costs attribute type');
        }

        if (!$data['dimensions'] instanceof Dimensions) {
            throw new \Exception('Invalid dimensions attribute type');
        }

        return new self($data['costs'], $data['dimensions'], $data['category']);
    }

    public static function fromModel(Product $product): self
    {
        return new self(
            $product->getCosts(),
            $product->getDimensions(),
            $product->getCategory()
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }
}
