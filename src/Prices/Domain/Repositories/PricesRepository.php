<?php

namespace Src\Prices\Domain\Repositories;

use DateTime;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

interface PricesRepository
{
    public function count(string $userId): int;

    public function getLastSynchronizationDateTime(string $userId): ?DateTime;

    public function insert(
        Price $price,
        Product $product,
        Marketplace $marketplace,
        float $commission,
        float $profit
    ): bool;

    public function update(
        Price $price,
        float $value,
        float $profit,
        float $commission
    ): bool;
}
