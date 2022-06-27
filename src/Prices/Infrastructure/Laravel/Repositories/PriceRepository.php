<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Src\Calculator\Domain\Models\Price\Contracts\Price as CalculatedPrice;
use Src\Math\MoneyTransformer;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class PriceRepository
{
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

    public function update(Price $model, CalculatedPrice $price): bool
    {
        $model->value = MoneyTransformer::toFloat($price->get());
        $model->profit = MoneyTransformer::toFloat($price->getProfit());
        $model->commission = $price->getCommission()->getCommissionRate();

        return $model->save();
    }
}
