<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Calculator\Domain\Models\Price\Contracts\Price as CalculatedPrice;
use Src\Math\MoneyTransformer;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Repositories\ProductRepository;

class PriceRepository
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function count(): int
    {
        $userId = auth()->user()->id;

        return Price::where('user_id', $userId)->count();
    }

    public function getLastSynchronizationDateTime(): ?Carbon
    {
        $userId = auth()->user()->id;
        $lastUpdatedProduct = Price::where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function insert(Price $price, float $commission, float $profit): bool
    {
        $product = $this->productRepository->get($price->product_sku);

        if (!$product) {
            return false;
        }

        $price->fill([
            'commission' => $commission,
            'profit' => $profit,
        ]);
        $price->product()->associate($product);
        $price->user_id = $price->getMarketplace()->user_id;

        return $price->save();
    }

    public function update(Price $model, float $value, float $profit, float $commission): bool
    {
        $model->value = $value;
        $model->profit = $profit;
        $model->commission = $commission;

        return $model->save();
    }

    public function updateFromCalculatedPrice(Price $model, CalculatedPrice $price): bool
    {
        return $this->update(
            $model,
            MoneyTransformer::toFloat($price->get()),
            MoneyTransformer::toFloat($price->getProfit()),
            $price->getCommission()->getCommissionRate()
        );
    }

    public function getPriceFromMarketplace(
        string $marketplaceSlug,
        string $marketplaceSkuId,
        string $productSku
    ): Collection
    {
        $userId = auth()->user()->getAuthIdentifier();

        return Price::where('user_id', $userId)
            ->where('store', $marketplaceSlug)
            ->where('store_sku_id', $marketplaceSkuId)
            ->where('product_sku', $productSku)
            ->get();
    }
}
