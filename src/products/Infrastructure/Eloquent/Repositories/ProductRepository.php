<?php

namespace Src\Products\Infrastructure\Eloquent\Repositories;

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
            ->orderBy('sku')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public function listProducts(string $storeSlug, int $page = 1)
    {
        return Product::with(
            [
                'prices' => function ($query) use ($storeSlug) {
                    $query->where('store', '=', $storeSlug);
                }
            ])
            ->active()
            ->orderBy('sku')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }
}
