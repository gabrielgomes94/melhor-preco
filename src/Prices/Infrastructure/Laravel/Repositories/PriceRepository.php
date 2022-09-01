<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\ProfitMargin;
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

    public function insert(
        Price $price,
        Product $product,
        Marketplace $marketplace,
        float $commission,
        float $profit
    ): bool
    {
        $price->fill([
            'commission' => $commission,
            'profit' => $profit,
            'margin' => ProfitMargin::calculate($price->getValue(), $profit)->get(),
        ]);
        $price->product()->associate($product);
        $price->marketplace()->associate($marketplace);
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
        Marketplace $marketplace,
        string $sku
    ): Collection
    {
        return $marketplace->getPrices()->filter(
            fn (Price $price) => $price->getProductSku() === $sku
        );
    }
}
