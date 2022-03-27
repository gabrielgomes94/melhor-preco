<?php

namespace Src\Promotions\Domain\Services;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Promotions\Domain\Data\PromotionSetup;

interface FilterProfitableProducts
{
    public function get(Marketplace $marketplace, PromotionSetup $promotionData): array;
}
