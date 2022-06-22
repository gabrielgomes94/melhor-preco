<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Src\Prices\Domain\Models\Price;

class Repository
{
    public function count(): int
    {
        $userId = auth()->user()->id;

        return Price::where('user_id', $userId)->count();
    }

    public function getLastSynchronizationDateTime(): ?Carbon
    {
        $userId = auth()->user()->id;
        $lastUpdatedProduct = Price::where('user_id', $userId)->orderByDesc('updated_at')->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }
}
