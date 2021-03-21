<?php

namespace Integrations\Bling\Products\Response\Transformers;

class Transformer
{
    public function transform(array $data)
    {
        if (!isset($data['product'])) {
            return $data;
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
}
