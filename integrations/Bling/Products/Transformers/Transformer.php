<?php

namespace Integrations\Bling\Products\Transformers;

class Transformer
{
    public function transform(array $data): array
    {
        if (!isset($data['product'])) {
            return [];
        }

        $product = $data['product'];

        if ($product['imagem']) {
            $images = array_map(function(array $image) {
                return $image['link'];
            }, $product['imagem']);
        }


        return [
            'product' => [
                'sku' => $product['codigo'],
                'name' => $product['descricao'],
                'brand' => $product['marca'],
                'images' => $images ?? [],
                'stock' => $product['estoqueAtual'] ?? 0,
                'purchasePrice' => $product['precoCusto'],
                'price' => $product['preco'],
            ]
        ];
    }


    public function transformStore(array $data, string $storeCode): array
    {
        if (!isset($data['product'])) {
            return [];
        }

        $product = $data['product'];

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

        return [
            'store' => $store ?? [],
        ];
    }
}
