<?php

namespace Integrations\Bling\Products\Transformers;

class Product
{
    public static function transform(array $product): array
    {
        if (!isset($product)) {
            return [];
        }

        return [
            'sku' => $product['codigo'],
            'name' => $product['descricao'],
            'brand' => $product['marca'],
            'images' => self::setImages($product),
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

    private static function setImages(array $product): array
    {
        if ($product['imagem']) {
            $images = array_map(function(array $image) {
                return $image['link'];
            }, $product['imagem']);
        }

        return $images ?? [];
    }
}