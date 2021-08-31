<?php

namespace Tests\Data\Models;

use Tests\Data\Models\Product\CompositionProduct;
use Tests\Data\Models\Product\SimpleProduct;
use Tests\Data\Models\Product\VariationProduct;

class ProductDataFactory
{
    private static array $types = [
        'simple' => SimpleProduct::class,
        'withVariations' => VariationProduct::class,
        'composition' => CompositionProduct::class,
    ];

    public static function make(string $type = 'simple', array $overwrite = [])
    {
        self::validateType($type);

        return self::$types[$type]::make($overwrite);
    }

    public static function create(string $type = 'simple', array $overwrite = [])
    {
        self::validateType($type);

        return self::$types[$type]::create($overwrite);
    }

    private static function validateType(string $type): void
    {
        if (!in_array($type, array_keys(self::$types))) {
            throw new \Exception("Invalid type '{$type}'");
        }
    }
}
