<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository as ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private const PER_PAGE = 15;

    // @todo: trocar o retorno desse método. Deve voltar ou array ou iterable
    public function all(string $userId): Collection
    {
        return Product::fromUser($userId)->get();
    }

    public function allFiltered(FilterOptions $filter, string $userId): LengthAwarePaginator
    {
        $query = Product::fromUser($userId);

        if ($filter->hasSku()) {
            $query = $query->withSku($filter->sku);
        }

        if ($filter->hasCategory()) {
            $query = $query->inCategory($filter->category);
        }

        $query = $query->orderBy('sku');

        return $query->paginate(perPage: $filter->perPage ?? self::PER_PAGE, page: $filter->page);
    }

    public function get(string $sku, string $userId): ?Product
    {
        $product = Product::fromUser($userId)
            ->where('sku', $sku)
            ->first();

        if (!$product) {
            return null;
        }

        return $product;
    }

    public function getLastSynchronizationDateTime(string $userId): ?Carbon
    {
        $lastUpdatedProduct = Product::fromUser($userId)
            ->orderByDesc('updated_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function count(string $userId): int
    {
        return Product::fromUser($userId)->count();
    }

    public function countActives(string $userId): int
    {
        return Product::fromUser($userId)
            ->active()
            ->count();
    }

    public function getProductByEan(string $ean, string $userId): ?Product
    {
        return Product::fromUser($userId)
            ->where('ean', $ean)
            ->first();
    }

    public function getProductsAndVariations(string $sku, string $userId): array
    {
        if (!$product = $this->get($sku, $userId)) {
            return [];
        }

        $products[] = $product;


        foreach ($product->getVariations()->get() as $variation) {
            $variationModel = $this->get($variation->getSku(), $userId);
            $products[] = $variationModel;
        }

        return $products;
    }

    public function updateCosts(Product $product, Costs $costs, string $userId): bool
    {
        $product->setCosts($costs);

        return $product->save();
    }

    public function save(Product $product, string $userId): bool
    {
        $product->user_id = $userId;

        return $product->save();
    }

    public function insert(Product $product, string $userId): bool
    {
        $product->user_id = $userId;
        $product->uuid = Uuid::uuid4();

        return $product->save();
    }
}
