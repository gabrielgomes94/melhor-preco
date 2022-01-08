<?php

namespace Src\Products\Infrastructure\Bling\Responses\Product;

use Src\Products\Domain\Models\Product\Product;

class Transformer
{
    public static function transform(array $data): Product
    {
        return new Product([
            'erp_id' => $data['id'],
            'ean' => $data['gtin'] ?? $data['gtinEmbalagem'],
            'sku' => $data['codigo'],
            'name' => $data['descricao'],
            'brand' => $data['marca'],
            'images' => self::getImages($data),
            'stock' => $data['estoqueAtual'] ?? 0,
            'purchase_price' => $data['precoCusto'] ?? 0.0,
            'tax_icms' => 0.0,
            'price' => $data['preco'],
            'depth' => (float) $data['profundidadeProduto'],
            'height' => (float) $data['alturaProduto'],
            'width' => (float) $data['larguraProduto'],
            'weight' => (float) $data['pesoBruto'],
            'parent_sku' => $data['codigoPai'] ?? null,
            'has_variations' => isset($data['variacoes']),
            'composition_products' => self::getCompositionProducts($data),
            'is_active' => self::isActive($data['situacao'] ?? '') ?? false,
        ]);
    }

    private static function getCompositionProducts(array $product = []): array
    {
        if (!isset($product['estrutura'])) {
            return [];
        }

        return array_map(function (array $compositionProduct) {
            return $compositionProduct['componente']['codigo'];
        }, $product['estrutura']);
    }

    private static function getImages(array $product): array
    {
        if (isset($product['imagem']) && $product['imagem']) {
            $images = array_map(function (array $image) {
                return $image['link'];
            }, $product['imagem']);
        }

        return $images ?? [];
    }

    private static function isActive(string $situation): bool
    {
        return $situation === 'Ativo';
    }
}
