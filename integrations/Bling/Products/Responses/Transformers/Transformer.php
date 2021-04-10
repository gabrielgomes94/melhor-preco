<?php

namespace Integrations\Bling\Products\Responses\Transformers;

class Transformer
{
    public function transform(array $data): array
    {
        if (!isset($data['product'])) {
            return [];
        }

        $product = $data['product'];
        $images = array_map(
            function($image) {
                return $image['link'];
            },
            $product['imagem']
        );

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
                'product_store_id' => $product['produtoLoja']['idProdutoLoja'] ?? '',
                'price' => (float) $product['produtoLoja']['preco']['preco'] ?? 0.0,
                'promotional_price' => (float) $product['produtoLoja']['preco']['precoPromocional'] ?? 0.0,
                'created_at' => $product['produtoLoja']['dataInclusao'] ?? '',
                'updated_at' => $product['produtoLoja']['dataAlteracao'] ?? '',
            ];
        }

        return [
            'store' => $store ?? [],
        ];
    }
}
