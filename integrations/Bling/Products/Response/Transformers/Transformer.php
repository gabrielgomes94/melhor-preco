<?php

namespace Integrations\Bling\Products\Response\Transformers;

class Transformer
{
    public function transform(array $data)
    {
        if (!isset($data['product'])) {
            return [];
        }

        $product = $data['product'];

        return [
            'product' => [
                'sku' => $product['codigo'],
                'name' => $product['descricao'],
                'brand' => $product['marca'],
                'images' => $product['imagem'],
                'stock' => $product['estoqueAtual'],
            ]
        ];
    }
}
