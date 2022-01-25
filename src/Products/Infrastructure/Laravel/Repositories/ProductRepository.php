<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository as ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private const PER_PAGE = 15;

    public function all(): Collection
    {
        return Product::active()->get();
    }

    public function get(string $sku): ?Product
    {
        $product = Product::where('sku', $sku)->first();

        if (!$product) {
            Log::info('Produto não encontrado.', [
                'sku' => $sku,
            ]);

            return null;
        }

        return $product;
    }

    public function getLastSynchronizationDateTime(): ?Carbon
    {
        $lastUpdatedProduct = Product::query()->orderByDesc('updated_at')->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function count(): int
    {
        return Product::query()->count();
    }

    public function countActives(): int
    {
        return Product::active()->count();
    }

    public function listProducts(string $storeSlug, int $page = 1): LengthAwarePaginator
    {
        return Product::with(
            [
                'prices' => function ($query) use ($storeSlug) {
                    $query->where('store', '=', $storeSlug);
                }
            ])
            ->active()
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
            ->where('sku', $sku)
            ->orWhere(function ($query) use ($sku, $storeSlug) {
                $query->where('parent_sku', $sku)
                    ->where('is_active', true);
            })
            ->orWhere(function ($query) use ($sku, $storeSlug) {
                $sku = '%"' . $sku . '"%';

                $query->where('composition_products', 'like', $sku)
                    ->where('is_active', true);
            })
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
            ->where('category_id', $categoryId)
            ->orderBySku()
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }
}
