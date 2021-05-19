<?php

namespace Integrations\Bling\Products\Transformers;


class Store
{
    public static function transform(array $product, string $storeCode): array
    {
        if (!isset($data)) {
            return [];
        }

        if (isset($product['produtoLoja'])) {
            $store = [
                'code' => $storeCode,
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
