<?php

namespace Barrigudinha\Pricing\Repositories\Contracts;

use Barrigudinha\Pricing\Data\Pricing as PricingData;

interface Pricing
{
    public function create(PricingData $pricing);
}

