<?php

namespace Src\Promotions\Domain\Data;

use Carbon\Carbon;
use Src\Math\Percentage;

class PromotionSetup
{
    public function __construct(
        public readonly Carbon $beginDate,
        public readonly Carbon $endDate,
        public readonly Percentage $discount,
        public readonly Percentage $marketplaceSubsidy,
        public readonly string $marketplaceSlug,
        public readonly string $name,
        public readonly int $productsMaxLimit
    )
    {}
}
