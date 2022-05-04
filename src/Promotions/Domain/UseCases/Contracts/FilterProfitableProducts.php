<?php

namespace Src\Promotions\Domain\UseCases\Contracts;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;

interface FilterProfitableProducts
{
    public function get(Marketplace $marketplace, PromotionSetup $promotionData): array;
}
