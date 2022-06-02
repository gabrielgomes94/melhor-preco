<?php

namespace Src\Products\Application\Services;

use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Utils\Contracts\Options;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

// @deprecated
class ListProducts
{
    public function all()
    {
        return Product::where('is_active', true)->get();
    }

    public function listPaginate(Options $options): LengthAwarePaginator
    {
        if (!$options->page()) {
            return Product::whereNull('parent_sku')
                ->where('is_active', true)
                ->orderBy('sku')
                ->all();
        }

        if ($sku = $options->sku()) {
            return Product::where('sku', $sku)
                ->orWhere('parent_sku', $sku)
                ->orWhere('composition_products', 'like', '%"' . $sku . '"%')
                ->orderBy('sku')
                ->paginate(perPage: $options->perPage(), page: $options->page());
        }


        return Product::whereNull('parent_sku')
            ->where('is_active', true)
            ->orderBy('sku')
            ->paginate(perPage: $options->perPage(), page: $options->page());
    }

    public function count(Options $options): int
    {
        return Product::whereNull('parent_sku')
            ->where('is_active', true)
            ->orderBy('sku')
            ->count();
    }
}
