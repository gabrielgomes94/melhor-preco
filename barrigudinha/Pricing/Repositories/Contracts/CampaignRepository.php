<?php

namespace Barrigudinha\Pricing\Repositories\Contracts;

use App\Models\PriceCampaign;
use Illuminate\Support\Enumerable;

interface CampaignRepository
{
    public function all(): Enumerable;

    public function find(string $id): PriceCampaign;
}
