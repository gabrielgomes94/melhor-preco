<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductWithPriceRepository as ProductWithPriceRepositoryInterface;

class ProductWithPriceRepository implements ProductWithPriceRepositoryInterface
{
    private const PER_PAGE = 15;

    public function listProducts(string $storeSlug, int $page = 1): LengthAwarePaginator
    {
        return Product::with(
            [
                'prices' => function ($query) use ($storeSlug) {
                    $query->where('store', '=', $storeSlug);
                }
            ]
        )
            ->active()
            ->isOnStore($storeSlug)
            ->orderBySku()
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public function listProductsBySku(string $storeSlug, string $sku, int $page = 1): LengthAwarePaginator
    {
        return Product::with([
            'prices' => function ($query) use ($storeSlug) {
                $query->where('store', '=', $storeSlug);
            }
        ])
            ->active()
            ->isOnStore($storeSlug)
            ->withSku($sku)
            ->orderBySku()
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public function listCompositionProducts(string $storeSlug, int $page): LengthAwarePaginator
    {
        return Product::with([
            'prices' => function ($query) use ($storeSlug) {
                $query->where('store', '=', $storeSlug);
            }
        ])
            ->active()
            ->isOnStore($storeSlug)
            ->whereNull('parent_sku')
            ->whereNotIn('composition_products', ['[]'])
            ->orderBySku()
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public function listProductsByCategory(string $storeSlug, string $categoryId, int $page = 1): LengthAwarePaginator
    {
        return Product::with([
            'prices' => function ($query) use ($storeSlug) {
                $query->where('store', '=', $storeSlug);
            }
        ])
            ->active()
            ->isOnStore($storeSlug)
            ->where('category_id', $categoryId)
            ->orderBySku()
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public function getProductByEan(string $ean): ?Product
    {
        return Product::where('ean', $ean)->first();
    }
}
