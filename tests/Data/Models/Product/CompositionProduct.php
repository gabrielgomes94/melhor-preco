<?php

namespace Tests\Data\Models\Product;

use Tests\Data\Models\Product\Contracts\ProductFactory;

class CompositionProduct implements ProductFactory
{
    public static function make(?array $overwrite = []): array
    {
        return self::build('make', $overwrite);
    }

    public static function create(?array $overwrite = []): array
    {
        return self::build('create', $overwrite);
    }

    private static function build(string $method, array $overwrite = []): array
    {
        if (!isset($overwrite['composition_products']) || empty($overwrite['composition_products'])) {
            throw new \Exception('Missing composition_products parameter');
        }

        foreach ($overwrite['composition_products'] as $composition) {
            $compositionProducts[] = SimpleProduct::{$method}(
                array_merge($overwrite, [
                    'id' => $composition,
                    'name' => 'Bebê Conforto',
                    'purchase_price' => 150.0,
                ])
            );
        }

        $mainProduct = SimpleProduct::{$method}(
            array_merge([
                'id' => '0001',
                'name' => 'Kit de Carrinho e Bebê Conforto',
            ], $overwrite)
        );

        return [$mainProduct, $compositionProducts];
    }
}
