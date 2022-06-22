<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Products\Application\Data\FilterOptions;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository as ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private const PER_PAGE = 15;

    public function all(): Collection
    {
        return Product::active()->get();
    }

    public function allFiltered(FilterOptions $filter): LengthAwarePaginator
    {
        $query = Product::active();

        if ($filter->hasSku()) {
            $query = $query->withSku($filter->sku);
        }

        if ($filter->hasCategory()) {
            $query = $query->inCategory($filter->category);
        }

        return $query->paginate(perPage: self::PER_PAGE, page: $filter->page);
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
        $userId = auth()->user()->id;

        return Product::query()->where('user_id', $userId)->count();
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
            ]
        )
            ->active()
            ->isOnStore($storeSlug)
            ->orderBySku()
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    // @deprecated
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

    // @deprecated
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

    // @deprecated
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

    public function getProductsAndVariations(string $sku): array
    {
        if (!$product = $this->get($sku)) {
            return [];
        }

        $products[] = $product;


        foreach ($product->getVariations()->get() as $variation) {
            $variationModel = $this->get($variation->getSku());
            $products[] = $variationModel;
        }

        return $products;
    }

    public function updateCosts(Product $product, Costs $costs): bool
    {
        $product->setCosts($costs);

        return $product->save();
    }
}
