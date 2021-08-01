<?php

namespace Integrations\Bling\Products\Responses\Transformers;

class ProductsCollection
{
    public static function transform(array $data): array
    {
        if (!isset($data)) {
            return [];
        }

        foreach ($data as $product) {
            $productsCollection[] = Product::transform($product['produto']);
        }

        return $productsCollection ?? [];
    }

    public static function transformWithStore(array $data, string $storeCode): array
    {
        if (!isset($data)) {
            return [];
        }

        foreach ($data as $product) {
            if (isset($product['produto']['produtoLoja'])) {
                $productsCollection[] = ProductStore::transform($product['produto'], $storeCode);
            }
        }

        return $productsCollection ?? [];
    }
}