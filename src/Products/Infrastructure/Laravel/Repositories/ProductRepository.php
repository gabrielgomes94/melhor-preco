<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Events\ProductSynchronized;
use Src\Products\Domain\Events\ProductWasNotSynchronized;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository as ProductRepositoryInterface;
use Src\Users\Domain\Entities\User;

class ProductRepository implements ProductRepositoryInterface
{
    private const PER_PAGE = 15;

    private string $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->getAuthIdentifier();
    }

    public function all(): Collection
    {
        return Product::fromUser($this->userId)
            ->active()
            ->get();
    }

    public function allFiltered(FilterOptions $filter): LengthAwarePaginator
    {
        $query = Product::fromUser($this->userId)
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
        $product = Product::fromUser($this->userId)
            ->where('sku', $sku)
            ->first();

        if (!$product) {
            return null;
        }

        return $product;
    }

    public function getLastSynchronizationDateTime(): ?Carbon
    {
        $lastUpdatedProduct = Product::fromUser($this->userId)
            ->orderByDesc('updated_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function count(): int
    {
        return Product::fromUser($this->userId)->count();
    }

    public function countActives(): int
    {
        return Product::fromUser($this->userId)
            ->active()
            ->count();
    }

    public function getProductByEan(string $ean): ?Product
    {
        return Product::fromUser($this->userId)
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
}
