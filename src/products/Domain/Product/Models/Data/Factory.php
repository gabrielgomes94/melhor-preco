<?php

namespace Src\Products\Domain\Product\Models\Data;

use Src\Products\Domain\Product\Contracts\Models\Data\Factory as FactoryInterface;
use Src\Products\Domain\Product\Contracts\Models\Data\Product;
use Src\Products\Domain\Product\Models\Data\Composition\Composition;
use Src\Products\Domain\Product\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Models\Data\Details\Details;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;
use Src\Products\Domain\Product\Models\Data\Identifiers\Identifiers;
use Src\Products\Domain\Product\Models\Data\ProductData as ProductObject;
use Src\Products\Domain\Product\Models\Data\Variations\Variations;
use Src\Products\Domain\Post\Factories\Factory as PostFactory;

class Factory implements FactoryInterface
{
    public static function make(array $data): Product
    {
        $costs = new Costs(
            purchasePrice: $data['purchase_price'],
            additionalCosts: $data['additional_costs'],
            taxICMS: $data['tax_icms']
        );

        $dimensions = new Dimensions($data['depth'], $data['height'], $data['width'], $data['weight']);

        foreach($data['prices'] as $price) {
            $posts[] = PostFactory::make(array_merge($price, [
                'costs' => $costs,
                'dimensions' => $dimensions,
            ]));
        }

        return new ProductObject(
            identifiers: new Identifiers($data['sku'], $data['erp_id']),
            costs: $costs,
            details: new Details($data['name'], $data['brand'], $data['images'] ?? []),
            dimensions: $dimensions,
            variations: new Variations($data['parent_sku'], $data['variations']),
            composition: new Composition($data['composition_products']),
            posts: $posts ?? [],
            isActive: $data['is_active'],
            stock: $data['stock']
        );
    }

    public static function update(ProductObject $product, array $data): Product
    {
        $data = $product->toArray();



    }
}
