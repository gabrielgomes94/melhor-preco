<?php

namespace Src\Products\Application\Services\Update;

use Src\Products\Application\Factories\Dimensions;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Details\Details;
use Src\Products\Domain\Models\Product\Data\Variations\Variations;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Product\Data\Composition\Composition;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions as DimensionsObject;

class UpdateProduct
{
    private UpdatePosts $updatePosts;

    public function __construct(UpdatePosts $updatePosts) {
        $this->updatePosts = $updatePosts;
    }

    public function execute(Product $product, array $data): bool
    {
        $dimensions = $this->getDimensions($product, $data);
        $product->setDimensions($dimensions);

        $compositions = $this->getCompositionProducts($data);
        $product->setCompositionProducts($compositions);

        $product->setCosts(
            new Costs(
                purchasePrice: $data['purchase_price'],
                additionalCosts: $data['additional_costs'] ?? 0.0,
                taxICMS: $data['tax_icms'] ?? 0.0
            )
        );

        $product->setDetails(
            new Details(
                name: $data['name'],
                brand: $data['brand'],
                images: $data['images'] ?? []
            )
        );

        $product->setVariations(new Variations($data['parent_sku'], $data['variations'] ?? []));

        $product->setActive($data['is_active'] ?? false);

        return $product->save();
    }

    private function getCompositionProducts(array $data): Composition
    {
        foreach ($data['composition_products'] as $compositionProduct) {
            $products[] = Product::find($compositionProduct);
        }

        return new Composition($products ?? []);
    }

    private function getDimensions(Product $product, array $data): DimensionsObject
    {
        return Dimensions::make($data, $product);
    }
}
