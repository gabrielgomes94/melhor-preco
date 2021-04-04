<?php

namespace App\Presenters\Pricing;

use App\Models\Pricing;
use Illuminate\Database\Eloquent\Collection;

class PricingList
{
    public function present(Collection $campaigns): array
    {
        $transformedCampaigns = [];

        foreach($campaigns as $campaign) {
            $name = $campaign->name;
            $products = $this->presentProducts($campaign);
            $stores = $this->presentShops($campaign);

            $transformedCampaigns[] = [
                'id' => $campaign->id,
                'name' => $name,
                'products' => implode(',', $products),
                'stores' => implode(',', $stores),
            ];
        }

        return $transformedCampaigns;
    }


    private function presentProducts(Pricing $pricing)
    {
        return $products = array_map(function($product) {
            if (isset($product['sku'])) {
                return (string) $product['sku'];
            }
        }, $pricing->products->toArray());
    }

    private function presentShops(Pricing $pricing)
    {
        return array_map(function($store) {
            if (isset($store['code'])) {
                return (string) $store['code'];
            }
        }, $pricing?->stores ?? []);
    }
}
