<?php

namespace App\Repositories\Product\Queries;

use App\Models\Product;
use Barrigudinha\Product\Repositories\Contracts\Query;
use Barrigudinha\Product\Utils\Contracts\Options;

class Products implements Query
{
    public static function count(Options $options): int
    {
        return self::query($options)->count();
    }

    public static function paginate(Options $options): array
    {
        return self::query($options)
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->items();
    }

    /**
     * @inheritDoc
     */
    public static function query(Options $options)
    {
        return Product::whereNull('parent_sku')
            ->where('is_active', true)
            ->orderBy('sku');
    }
}
