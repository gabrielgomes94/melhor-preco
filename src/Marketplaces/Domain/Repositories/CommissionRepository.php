<?php

namespace Src\Marketplaces\Domain\Repositories;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Domain\Models\Product\Product;

interface CommissionRepository
{
    public function get(Marketplace $marketplace, Product $product): float;

    public function updateCategoryCommissions(string $marketplaceSlug, array $data): bool;

    public function updateUniqueCommission(string $marketplaceSlug, float $commission): bool;
}
