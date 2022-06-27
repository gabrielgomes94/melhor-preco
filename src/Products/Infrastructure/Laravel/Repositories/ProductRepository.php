<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository as ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private const PER_PAGE = 15;

    public function all(): Collection
    {
        $userId = $this->getUserIdentifier();

        return Product::fromUser($userId)
            ->active()
            ->get();
    }

    public function allFiltered(FilterOptions $filter): LengthAwarePaginator
    {
        $userId = $this->getUserIdentifier();
        $query = Product::fromUser($userId)
            ->active();

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
        $userId = $this->getUserIdentifier();
        $product = Product::fromUser($userId)
            ->where('sku', $sku)
            ->first();

        if (!$product) {
            return null;
        }

        return $product;
    }

    public function getLastSynchronizationDateTime(): ?Carbon
    {
        $userId = $this->getUserIdentifier();
        $lastUpdatedProduct = Product::fromUser($userId)
            ->orderByDesc('updated_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function count(): int
    {
        $userId = $this->getUserIdentifier();
        return Product::fromUser($userId)->count();
    }

    public function countActives(): int
    {
        return Product::fromUser($this->userId)
            ->active()
            ->count();
    }

    public function getProductByEan(string $ean): ?Product
    {
        $userId = $this->getUserIdentifier();

        return Product::fromUser($userId)
            ->where('ean', $ean)
            ->first();
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

    public function save(Product $product, string $userId): bool
    {
        $product->user_id = $userId;

        return $product->save();
    }

    private function getUserIdentifier(): string
    {
        return auth()->user()->getAuthIdentifier();
    }
}
