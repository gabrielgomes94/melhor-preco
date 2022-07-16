<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductWithPriceRepository as ProductWithPriceRepositoryInterface;

class ProductWithPriceRepository implements ProductWithPriceRepositoryInterface
{
    private const PER_PAGE = 15;

    public function listProducts(string $storeSlug, string $userId, int $page = 1): LengthAwarePaginator
    {
        return Product::with(
            [
                'prices' => function ($query) use ($storeSlug) {
                    $query->where('store', '=', $storeSlug);
                }
            ]
        )
            ->where('user_id', $userId)
            ->active()
            ->isOnStore($storeSlug)
            ->isNotVariation()
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
            ->isNotVariation()
            ->where('category_id', $categoryId)
            ->orderBySku()
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public function getProductByEan(string $ean): ?Product
    {
        return Product::where('ean', $ean)->first();
    }
}
