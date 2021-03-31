<?php

namespace App\Repositories\Pricing;

use App\Models\PriceCampaign;
use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PricingRepository implements PricingRepositoryInterface
{
    public function create(Pricing $pricing): bool
    {
        $pricingModel = new PriceCampaign();

        $pricingModel->name = $pricing->name;
        $pricingModel->products = collect($pricing->products);
        $pricingModel->stores = $pricing->stores;

        return $pricingModel->save();
    }

    public function all(): Collection
    {
        return PriceCampaign::all();
    }

    public function find(string $id): ?PriceCampaign
    {
        return PriceCampaign::find($id);
    }
}
