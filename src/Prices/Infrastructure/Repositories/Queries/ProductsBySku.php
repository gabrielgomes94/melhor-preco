<?php

namespace Src\Prices\Infrastructure\Repositories\Queries;

use App\Models\Product;
use Barrigudinha\Product\Repositories\Contracts\Query;
use Barrigudinha\Product\Utils\Contracts\Options;

class ProductsBySku implements Query
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
        $sku = $options->sku();

        return Product::where('sku', $sku)
            ->orWhere('parent_sku', $sku)
            ->orWhere('composition_products', 'like', '%"' . $sku . '"%')
            ->orderBy('sku');
    }
}
