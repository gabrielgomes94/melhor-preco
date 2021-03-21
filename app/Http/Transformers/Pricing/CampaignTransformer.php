<?php


namespace App\Http\Transformers\Pricing;

use App\Http\Transformers\Pricing\Data\CreatePricing;
use Illuminate\Database\Eloquent\Collection;

class CampaignTransformer
{
    public function list(Collection $campaigns): array
    {
        $transformedCampaigns = [];

        foreach($campaigns as $campaign) {
            $name = $campaign->name;
            $products = array_map(function($product) {
                if (isset($product['sku'])) {
                    return (string) $product['sku'];
                }
            }, $campaign->products);

            $stores = array_map(function($store) {
                if (isset($store['code'])) {
                    return (string) $store['code'];
                }
            }, $campaign->stores);

            $transformedCampaigns[] = [
                'name' => $name,
                'products' => implode(',', $products),
                'stores' => implode(',', $stores),
            ];
        }

        return $transformedCampaigns;
    }
}

