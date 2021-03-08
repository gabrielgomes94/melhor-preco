<?php

namespace Barrigudinha\Pricing\Repositories\Contracts;

use Illuminate\Support\Enumerable;

interface CampaignRepository
{
    public function all(): Enumerable;
}
