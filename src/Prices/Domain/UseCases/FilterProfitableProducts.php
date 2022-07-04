<?php

namespace Src\Prices\Domain\UseCases;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\DataTransfer\PromotionSetup;

interface FilterProfitableProducts
{
    public function get(Marketplace $marketplace, PromotionSetup $promotionData): array;
}
