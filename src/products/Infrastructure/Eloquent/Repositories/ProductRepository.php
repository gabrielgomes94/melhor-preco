<?php

namespace Src\Products\Infrastructure\Eloquent\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository as ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
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

    public function getLastSynchronizationDateTime(): Carbon
    {
        $lastUpdatedProduct = Product::query()->orderByDesc('updated_at')->first();

        return $lastUpdatedProduct->getLastUpdate();
    }

    public function count(): int
    {
        return Product::query()->count();
    }

    public function countActives(): int
    {
        return Product::active()->count();
    }
}
