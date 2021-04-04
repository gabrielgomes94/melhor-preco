<?php

namespace App\Presenters\Pricing;

use App\Models\PriceCampaign;
use App\Models\Pricing;
use App\Presenters\Pricing\Data\DetailedPricing;

class Show
{
    public function present(Pricing $pricing): array
    {
        $detailedPricing = DetailedPricing::createFromModel($pricing);

        return $detailedPricing->toArray();
    }
}
