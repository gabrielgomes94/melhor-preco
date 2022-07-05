<?php

namespace Src\Marketplaces\Domain\Repositories;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product\Product;

interface CommissionRepository
{
    public function get(Marketplace $marketplace, ?string $categoryId = null): Percentage;

    public function updateCategoryCommissions(Marketplace $marketplace, array $data): bool;

    public function updateUniqueCommission(Marketplace $marketplace, float $commission): bool;
}
