<?php

namespace Src\Promotions\Application\Data;

use Carbon\Carbon;
use Src\Math\Percentage;

class PromotionSetup
{
    public readonly int $maxProductsQuantity;
    public readonly string $name;
    public readonly string $marketplaceSlug;
    public readonly Carbon $promotionBeginDate;
    public readonly Carbon $promotionEndDate;
    public readonly Percentage $minimumMargin;
    public readonly Percentage $maximumDiscount;
    public readonly Percentage $minimumDiscount;
    public readonly Percentage $sellerSubsidy;
    public readonly Percentage $marketplaceSubsidy;

    public function __construct(array $data = [])
    {
        $this->name = $data['name'];
        $this->sellerSubsidy = Percentage::fromPercentage($data['subsidy']['seller']);
        $this->marketplaceSubsidy = Percentage::fromPercentage(100 - $data['subsidy']['seller']);
        $this->minimumDiscount = Percentage::fromPercentage($data['discount']['minimum']);
        $this->maximumDiscount = Percentage::fromPercentage($data['discount']['maximum']);
        $this->minimumMargin = Percentage::fromPercentage($data['minimumMargin']);
        $this->maxProductsQuantity = $data['maxProductsQuantity'];
        $this->marketplaceSlug = $data['marketplaceSlug'];
        $this->promotionBeginDate = Carbon::createFromFormat('Y-m-d', $data['promotionPeriod']['begin']);
        $this->promotionEndDate = Carbon::createFromFormat('Y-m-d', $data['promotionPeriod']['end']);
    }

    public function getDiscount(): float
    {
        return $this->maximumDiscount->get();
    }
}
