<?php

namespace Src\Prices\Infrastructure\Repositories\Product\Queries;

use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Contracts\Repositories\Query;
use Src\Products\Domain\Contracts\Utils\Options;
use Illuminate\Database\Eloquent\Builder;

class Products implements Query
{
    public static function count(Options $options): int
    {
        return self::query($options)->count();
    }

    public static function paginate(Options $options): array
    {
        return self::query($options)
            ->orderBy('product_id')
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->items();
    }

    public static function query(Options $options): Builder
    {
        $store = $options->store();

        return Product::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->whereNotNull('product_id')
            ->where('store', $store);
    }
}
