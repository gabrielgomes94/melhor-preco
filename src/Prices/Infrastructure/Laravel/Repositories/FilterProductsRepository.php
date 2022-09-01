<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class FilterProductsRepository
{
    public function __construct()
    {
    }

    public function list(Options $options): LengthAwarePaginator
    {
        $baseQuery = Product::with([
            'prices' => function ($query) use ($options) {
                $query->where('store', '=', $options->marketplaceSlug);
        }])
            ->where('user_id', $options->getUserId())
            ->isOnStore($options->marketplaceSlug)
            ->isNotVariation();

        if ($options->hasProfitFilters()) {
            $baseQuery->whereHas('prices', function (Builder $query) use ($options) {
                $query->where('margin', '>=', $options->minimumProfit())
                    ->where('margin', '<=', $options->maximumProfit());
            });
        }

        if ($options->hasCategories()) {
            $baseQuery->where('category_id', $options->categoryId);
        }

        if ($options->hasSku()) {
            $baseQuery->withSku($options->sku());
        }

        if ($options->shouldFilterKits()) {
            $baseQuery->whereNotIn('composition_products', ['[]']);
        }

        return $baseQuery->orderBySku()->paginate(
            perPage: $options->perPage,
            page: $options->page
        );
    }
}
