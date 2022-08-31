<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class PriceRepository
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function count(string $userId): int
    {
        return Price::join('products', 'products.uuid', '=', 'prices.product_uuid')
            ->where('products.user_id', $userId)
            ->count();
    }

    public function getLastSynchronizationDateTime(string $userId): ?Carbon
    {
        $lastUpdatedProduct = Price::join('products', 'products.uuid', '=', 'prices.product_uuid')
            ->where('products.user_id', $userId)
            ->orderByDesc('prices.updated_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function insert(Price $price, float $commission, float $profit, string $userId): bool
    {
        $product = $this->productRepository->get($price->product_sku, $userId);

        if (!$product) {
            return false;
        }

        $value = $price->value;

        $price->fill([
            'commission' => $commission,
            'profit' => $profit,
            'margin' => $value != 0 ? ($profit / $value) * 100 : 0,
        ]);
        $price->product()->associate($product);
        $price->uuid = Uuid::uuid4();

        return $price->save();
    }

    public function update(Price $model, float $value, float $profit, float $commission): bool
    {
        $model->value = $value;
        $model->profit = $profit;
        $model->margin = $value != 0 ? ($profit / $value) * 100 : 0;

        $model->commission = $commission;

        return $model->save();
    }

    public function getPriceFromMarketplace(
        string $marketplaceSlug,
        string $marketplaceSkuId,
        string $productSku,
        string $userId
    ): Collection
    {
        return Price::where('store', $marketplaceSlug)
            ->where('store_sku_id', $marketplaceSkuId)
            ->where('product_sku', $productSku)
            ->get();
    }
}
