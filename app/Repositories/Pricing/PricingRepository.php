<?php

namespace App\Repositories\Pricing;

use App\Models\PriceCampaign;
use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepositoryInterface;

class PricingRepository implements PricingRepositoryInterface
{
    public function create(Pricing $pricing)
    {
        $pricingModel = new PriceCampaign();

        $pricingModel->name = $pricing->name;
        $pricingModel->products = collect($pricing->products);
        $pricingModel->stores = $pricing->stores;

        $pricingModel->save();
    }
}
