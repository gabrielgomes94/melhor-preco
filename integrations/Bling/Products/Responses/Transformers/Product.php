<?php

namespace Integrations\Bling\Products\Responses\Transformers;

use Integrations\Bling\Products\Responses\Data\Product as ProductData;

class Product
{
    public static function transform(array $data): ?ProductData
    {
        if (!isset($data)) {
            return null;
        }

        $data = self::getData($data);

        return ProductData::createFromArray($data);
    }

    public static function transformWithStore(array $data, string $storeSlug): ?ProductData
    {
        if (!isset($data)) {
            return null;
        }

        $product = self::transform($data);
        $product->addStore(Store::transform($data, $storeSlug));

        return $product;
    }

    private static function getData(array $product): array
    {
        return [
            'erpId' => $product['id'],
            'sku' => $product['codigo'],
            'name' => $product['descricao'],
            'brand' => $product['marca'],
            'images' => self::getImages($product),
            'stock' => $product['estoqueAtual'] ?? 0,
            'purchasePrice' => $product['precoCusto'] ?? 0.0,
            'price' => $product['preco'],
            'depth' => (float) $product['profundidadeProduto'],
            'height' => (float) $product['alturaProduto'],
            'width' => (float) $product['larguraProduto'],
            'weight' => (float) $product['pesoBruto'],
            'parentSku' => $product['codigoPai'] ?? null,
            'hasVariations' => isset($product['variacoes']),
        ];
    }

    private static function getImages(array $product): array
    {
        if ($product['imagem']) {
            $images = array_map(function (array $image) {
                return $image['link'];
            }, $product['imagem']);
        }

        return $images ?? [];
    }
}
