<?php

namespace App\Factories\Product;

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
            $post = Post::buildFromERP($data['store']);
            $product->addPost($post);
        }

        return $product;
    }
}
