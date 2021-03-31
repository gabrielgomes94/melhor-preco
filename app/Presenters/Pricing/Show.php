<?php

namespace App\Presenters\Pricing;

use App\Models\PriceCampaign;
use App\Presenters\Pricing\Data\DetailedPricing;

class Show
{
    public function present(PriceCampaign $pricing): DetailedPricing
    {
        return DetailedPricing::createFromModel($pricing);
    }
}
