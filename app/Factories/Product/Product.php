<?php

namespace App\Factories\Product;

use App\Models\Product as ProductModel;
use Barrigudinha\Product\Dimensions;
use Barrigudinha\Product\Product as ProductObject;

class Product
{
    public static function buildFromERP(array $data): ProductObject
    {
        $dimensions = new Dimensions(
            depth: $data['dimensions']['depth'] ?? 0.0,
            height: $data['dimensions']['height'] ?? 0.0,
            width: $data['dimensions']['width'] ?? 0.0
        );

        $product = new ProductObject(
            sku: $data['sku'],
            name: $data['name'],
            brand: $data['brand'] ?? '',
            images: $data['images'] ?? [],
            stock: $data['stock'] ?? 0,
            purchasePrice: $data['purchasePrice'] ?? 0.0,
            dimensions: $dimensions,
            weight: $data['weight'] ?? 0.0,
            taxICMS: $data['tax_icms'] ?? null
        );

        if (isset($data['store'])) {
            $post = Post::build($data['store']);
            $product->addPost($post);
        }

        return $product;
    }

    public static function buildFromModel(ProductModel $model): ProductObject
    {
        $dimensions = new Dimensions($model->depth, $model->height, $model->width);

        $product = new ProductObject(
            sku: $model->sku,
            name: $model->name,
            brand: $model->brand ?? '',
            images: $model->images ?? [],
            stock: $model->stock ?? 0,
            purchasePrice: $model->purchasePrice ?? 0.0,
            dimensions: $dimensions,
            weight: $model->weight ?? 0.0,
            taxICMS: $model->tax_icms ?? null
        );

        foreach ($model->prices as $pricePost) {
            $post = Post::buildFromModel($pricePost);
            $product->addPost($post);
        }

        return $product;
    }
}
