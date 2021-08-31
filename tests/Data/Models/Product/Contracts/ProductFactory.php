<?php

namespace Tests\Data\Models\Product\Contracts;

interface ProductFactory
{
    public const SIMPLE = 'simple';
    public const WITH_VARIATIONS = 'withVariations';
    public const COMPOSITION = 'composition';

    public static function make(array $overwrite = []);

    public static function create(array $overwrite = []);
}
