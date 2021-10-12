<?php

namespace Tests\Data\Models\Product;

use Src\Products\Domain\Models\Product;
use Tests\Data\Models\Product\Contracts\ProductFactory;

class VariationProduct implements ProductFactory
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
        if (!isset($overwrite['variations']) || empty($overwrite['variations'])) {
            throw new \Exception('Missing variations parameter');
        }

        $parentProduct = SimpleProduct::{$method}(
            array_merge($overwrite, ['has_variations' => true])
        );

        $i = 0;
        foreach ($overwrite['variations'] as $variation) {
            $childrenProducts[] = SimpleProduct::{$method}(
                array_merge($overwrite, [
                    'id' => $variation,
                    'name' => $parentProduct->name . ' Variação ' . ++$i,
                    'parent_sku' => $parentProduct->id,
                ])
            );
        }

        return array_merge([$parentProduct], $childrenProducts ?? []);
    }
}
