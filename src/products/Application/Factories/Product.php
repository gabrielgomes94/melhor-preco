<?php

namespace Src\Products\Application\Factories;

use Src\Products\Application\Factories\Post;
use Src\Products\Domain\Models\Product as ProductModel;
use Src\Products\Domain\Data\Compositions\Composition;
use Src\Products\Domain\Data\Costs;
use Src\Products\Domain\Data\Dimensions;
use Src\Products\Domain\Data\Store;
use Src\Products\Domain\Entities\Product as ProductObject;
use Src\Products\Domain\Data\Variations\NoVariations;
use Src\Products\Domain\Data\Variations\Variations;
use Src\Products\Domain\Entities\ProductsCollection;
use Barrigudinha\Utils\Helpers;

class Product
{
    public static function buildFromModel(ProductModel $model): ProductObject
    {
        $variationProducts = self::getVariations($model);
        $composition = self::getComposition($model);
        $product = self::build($model, $variationProducts ?? [], $composition ?? []);
        $product = self::setPrices($model, $product);

        return $product;
    }

    public static function buildWithPrice(ProductModel $model): ProductObject
    {
        $variationProducts = self::getVariations($model);
        $composition = self::getComposition($model);
        $product = self::build($model, $variationProducts ?? [], $composition ?? []);

        $post = Post::buildFromArray([
            'id' => $model->id,
            'price' => $model->value,
            'storeSlug' => $model->store,
            'storeSkuId' => $model->store_sku_id,
            'profit' => $model->profit,
        ]);

        $product->addPost($post);
        $product->addStore($post->store());

        return $product;
    }

    private static function getComposition(ProductModel $model): ProductsCollection
    {
        if ($model->hasCompositionProducts()) {
            $compositionProducts = $model->compositionProducts();

            foreach ($compositionProducts as $compositionProduct) {
                $composition[] = self::build($compositionProduct);
            }
        }

        return new ProductsCollection($composition ?? []);
    }

    private static function getVariations(ProductModel $model): array
    {
        if ($model->has_variations) {
            $variations = $model->getVariations();
            foreach ($variations as $variation) {
                $variationProducts[] = self::build($variation);
            }
        }

        return $variationProducts ?? [];
    }

    private static function build(ProductModel $model, ?array $variationProducts = null, ?ProductsCollection $compositionProducts = null): ProductObject
    {
        $dimensions = new Dimensions($model->depth, $model->height, $model->width, $model->weight);

        $costs = new Costs(
            purchasePrice: $model->purchase_price ?? 0.0,
            additionalCosts:$model->additional_costs,
            taxICMS: $model->tax_icms ?? null
        );

        $variations = $variationProducts
            ? new Variations($variationProducts)
            : new NoVariations();

        $composition = new Composition($compositionProducts ?? new ProductsCollection());

        $product = new ProductObject(
            sku: $model->sku,
            name: $model->name,
            brand: $model->brand ?? '',
            images: $model->images ?? [],
            hasVariations: $model->has_variations,
            isActive: $model->isActive(),
            stock: $model->stock ?? 0,
            dimensions: $dimensions,
            taxICMS: $model->tax_icms ?? null,
            erpId: $model->erp_id ?? null,
            parentSku: $model->parent_sku,
            additionalCosts:$model->additional_costs,
            costs: $costs,
            variations: $variations,
            compositionProducts: $composition
        );

        return $product;
    }

    private static function setPrices(ProductModel $model, ProductObject $product): ProductObject
    {
        foreach ($model->prices as $pricePost) {
            $post = Post::buildFromModel($pricePost);
            $store = $post->store();

            $product->addPost($post);
            $product->addStore($store);
        }

        return $product;
    }
}