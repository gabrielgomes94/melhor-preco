<?php

namespace Src\Prices\PriceList\Infrastructure\Repositories\Product\Queries;

use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Contracts\Repositories\Query;
use Src\Products\Domain\Contracts\Utils\Options;
use Illuminate\Database\Eloquent\Builder;

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

    public static function query(Options $options): Builder
    {
        $store = $options?->store();
        $sku = $options?->sku();

        return Product::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->where('store', $store)
            ->where('sku', $sku)
            ->where('is_active', true)
            ->orWhere(function ($query) use ($sku, $store) {
                $query->where('parent_sku', $sku)
                    ->where('store', $store)
                    ->where('is_active', true);
            })
            ->orWhere(function ($query) use ($sku, $store) {
                $sku = '%"' . $sku .'"%';

                $query->where('composition_products', 'like', $sku)
                    ->where('store', $store)
                    ->where('is_active', true);
            })
            ->orderBy('product_id');
    }
}
