<?php

namespace Tests\Data\Models;

use Tests\Data\Models\Product\CompositionProduct;
use Tests\Data\Models\Product\Contracts\ProductFactory;
use Tests\Data\Models\Product\SimpleProduct;
use Tests\Data\Models\Product\VariationProduct;

class ProductDataFactory
{
    /**
     * @var array<string, ProductFactory>
     */
    private static array $types = [
        ProductFactory::SIMPLE => SimpleProduct::class,
        ProductFactory::WITH_VARIATIONS => VariationProduct::class,
        ProductFactory::COMPOSITION => CompositionProduct::class,
    ];

    public static function make(array $overwrite = [], string $type = 'simple')
    {
        self::validateType($type);

        return self::$types[$type]::make($overwrite);
    }

    public static function create(array $overwrite = [], string $type = 'simple')
    {
        self::validateType($type);

        return self::$types[$type]::create($overwrite);
    }

    public static function makeCollection(array $overwrite = [], string $type = 'simple')
    {
        if (empty($overwrite)) {
            return self::$types[$type]::make([]);
        }

        foreach ($overwrite as $attributes) {
            $products[] = self::$types[$type]::make($attributes);
        }

        return $products ?? [];
    }

    public static function createCollection(array $overwrite = [], string $type = 'simple')
    {
        if (empty($overwrite)) {
            return self::$types[$type]::create([]);
        }

        foreach ($overwrite as $attributes) {
            $products[] = self::$types[$type]::create($attributes);
        }

        return $products ?? [];
    }

    private static function validateType(string $type): void
    {
        if (!in_array($type, array_keys(self::$types))) {
            throw new \Exception("Invalid type '{$type}'");
        }
    }
}
