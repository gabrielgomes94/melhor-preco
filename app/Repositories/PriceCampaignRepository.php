<?php

namespace App\Repositories;

use App\Models\PriceCampaign;
use Barrigudinha\Pricing\Repositories\Contracts\CampaignRepository;
use Illuminate\Database\Eloquent\Collection;

class PriceCampaignRepository implements CampaignRepository
{
    public function all(): Collection
    {
        return PriceCampaign::all();
    }
}
