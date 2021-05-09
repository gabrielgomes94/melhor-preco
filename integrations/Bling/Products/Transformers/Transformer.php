<?php

namespace Integrations\Bling\Products\Transformers;

class Transformer
{
    public function product(array $data): array
    {
        if (!isset($data)) {
            return [];
        }

        $product = $data;

        if ($product['imagem']) {
            $images = array_map(function(array $image) {
                return $image['link'];
            }, $product['imagem']);
        }

        return [
                'sku' => $product['codigo'],
                'name' => $product['descricao'],
                'brand' => $product['marca'],
                'images' => $images ?? [],
                'stock' => $product['estoqueAtual'] ?? 0,
                'purchasePrice' => $product['precoCusto'],
                'price' => $product['preco'],
                'dimensions' => [
                    'depth' => (float) $product['profundidadeProduto'],
                    'height' => (float) $product['alturaProduto'],
                    'width' => (float) $product['larguraProduto'],
                ],
        ];
    }

    public function store(array $data, string $storeCode): array
    {
        if (!isset($data)) {
            return [];
        }

        $product = $data;

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


    public function productsCollection(array $data): array
    {
        if (!isset($data)) {
            return [];
        }

        foreach ($data as $product) {
            $productsCollection[] = $this->product($product['produto']);
        }

        return $productsCollection ?? [];
    }
}
