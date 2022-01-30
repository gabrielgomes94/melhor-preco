<?php

namespace Src\Products\Infrastructure\Bling\Responses\Prices;

use Src\Prices\Domain\Models\Price;

class Transformer
{
    public static function transform(string $storeSlug, string $storeCode, array $product): ?Price
    {
        if (!isset($product)) {
            return null;
        }

        if (!isset($product['produtoLoja'])) {
            return null;
        }

        return new Price([
            'store' => $storeSlug,
            'store_sku_id' => $product['produtoLoja']['idProdutoLoja'] ?? '',
            'value' => (float) $product['produtoLoja']['preco']['preco'] ?? 0.0,
            'created_at' => $product['produtoLoja']['dataInclusao'] ?? '',
            'updated_at' => $product['produtoLoja']['dataAlteracao'] ?? '',
            'product_sku' => $product['codigo'],
            'marketplace_erp_id' => $storeCode,
        ]);
    }
}
