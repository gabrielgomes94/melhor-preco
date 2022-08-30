<?php

namespace Src\Marketplaces\Domain\Repositories;

use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product;

interface CommissionRepository
{
    public function get(Marketplace $marketplace, Product $product, float $value): float;

    public function getCommissionRate(Marketplace $marketplace, ?string $categoryId = null): Percentage;

    public function update(Marketplace $marketplace, CommissionValuesCollection $data): bool;
}
