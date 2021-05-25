<?php

namespace Integrations\Bling\Products\Transformers;

class Store
{
    public static function transform(array $product, string $storeSlug): array
    {
        if (!isset($product)) {
            return [];
        }

        if (isset($product['produtoLoja'])) {
            $store = [
                'code' => $storeSlug,
                'skuStoreId' => $product['produtoLoja']['idProdutoLoja'] ?? '',
                'price' => (float) $product['produtoLoja']['preco']['preco'] ?? 0.0,
                'promotionalPrice' => (float) $product['produtoLoja']['preco']['precoPromocional'] ?? 0.0,
                'createdAt' => $product['produtoLoja']['dataInclusao'] ?? '',
                'updatedAt' => $product['produtoLoja']['dataAlteracao'] ?? '',
            ];
        }

        return $store ?? [];
    }
}
