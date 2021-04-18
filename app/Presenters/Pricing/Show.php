<?php

namespace App\Presenters\Pricing;

use App\Models\Pricing as PricingModel;
use App\Presenters\Pricing\Show\Pricing;

class Show
{
    public function present(PricingModel $pricing): Pricing
    {
        return new Pricing($pricing);
    }
}
