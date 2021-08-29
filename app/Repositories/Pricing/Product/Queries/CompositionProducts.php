<?php

namespace App\Repositories\Pricing\Product\Queries;

use App\Models\Product as ProductModel;
use Barrigudinha\Product\Repositories\Contracts\Query;
use Barrigudinha\Product\Utils\Contracts\Options;
use Illuminate\Database\Eloquent\Builder;

class CompositionProducts implements Query
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

    public static function query(Options $options): Builder
    {
        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->whereNotNull('product_id')
            ->whereNotIn('composition_products', ['[]'])
            ->where('store', $options->store())
            ->orderBy('product_id');
    }
}
