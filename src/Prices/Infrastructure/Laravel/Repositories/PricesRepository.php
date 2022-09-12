<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\Calculators\ProfitMargin;
use Src\Prices\Domain\Repositories\PricesRepository as PricesRepositoryInterface;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class PricesRepository implements PricesRepositoryInterface
{
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

    public function update(Price $price, float $value, float $profit, float $commission): bool
    {
        $price->value = $value;
        $price->profit = $profit;
        $price->commission = $commission;
        $price->margin = ProfitMargin::calculate($value, $profit)->get();;

        return $price->save();
    }
}
