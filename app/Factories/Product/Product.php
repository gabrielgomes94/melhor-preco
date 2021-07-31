<?php

namespace App\Factories\Product;

use App\Models\Product as ProductModel;
use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Dimensions;
use Barrigudinha\Product\Product as ProductObject;
use Barrigudinha\Product\Variations\NoVariations;
use Barrigudinha\Product\Variations\Variations;

class Product
{
    public static function buildFromModel(ProductModel $model): ProductObject
    {
        if ($model->has_variations) {
            $variations = $model->getVariations();
            foreach ($variations as $variation) {
                $variationProducts[] = self::build($variation);
            }
        }

        $product = self::build($model, $variationProducts ?? []);

        return $product;
    }

    private static function build(ProductModel $model, ?array $variationProducts = null): ProductObject
    {
        $dimensions = new Dimensions($model->depth, $model->height, $model->width);

        $costs = new Costs(
            purchasePrice: $model->purchase_price ?? 0.0,
            additionalCosts:$model->additional_costs,
            taxICMS: $model->tax_icms ?? null
        );

        $variations = $variationProducts
            ? new Variations($variationProducts)
            : new NoVariations();

        $product = new ProductObject(
            sku: $model->sku,
            name: $model->name,
            brand: $model->brand ?? '',
            images: $model->images ?? [],
            hasVariations: $model->has_variations,
            stock: $model->stock ?? 0,
            dimensions: $dimensions,
            weight: $model->weight ?? 0.0,
            taxICMS: $model->tax_icms ?? null,
            erpId: $model->erp_id ?? null,
            parentSku: $model->parent_sku,
            additionalCosts:$model->additional_costs,
            costs: $costs,
            variations: $variations
        );

        foreach ($model->prices as $pricePost) {
            $post = Post::buildFromModel($pricePost);
            $store = $post->store();

            $product->addPost($post);
            $product->addStore($store);
        }

        return $product;
    }
}
