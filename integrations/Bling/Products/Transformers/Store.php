<?php

namespace Integrations\Bling\Products\Transformers;

use Integrations\Bling\Products\Data\Store as StoreData;

class Store
{
    public static function transform(array $product, string $storeSlug): ?StoreData
    {
        if (!isset($product)) {
            return null;
        }

        if (!isset($product['produtoLoja'])) {
            return null;
        }

        $store = self::getData($product, $storeSlug);
        return StoreData::createFromArray($store);
    }

    private static function getData(array $product, string $storeSlug): array
    {
        return [
            'code' => $storeSlug,
            'storeSkuId' => $product['produtoLoja']['idProdutoLoja'] ?? '',
            'price' => (float) $product['produtoLoja']['preco']['preco'] ?? 0.0,
            'promotionalPrice' => (float) $product['produtoLoja']['preco']['precoPromocional'] ?? 0.0,
            'createdAt' => $product['produtoLoja']['dataInclusao'] ?? '',
            'updatedAt' => $product['produtoLoja']['dataAlteracao'] ?? '',
        ];
    }
}
