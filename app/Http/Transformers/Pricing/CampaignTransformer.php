<?php


namespace App\Http\Transformers\Pricing;

use App\Http\Transformers\Pricing\Data\Campaign;
use Illuminate\Database\Eloquent\Collection;

class CampaignTransformer
{
    public function list(Collection $campaigns): array
    {
        $transformedCampaigns = $campaigns->map(function($campaign) {
            $name = $campaign->name;
            $products = array_map(function($product) { return $product['sku']; },
                $campaign->products);

            return new Campaign($name, $products);
        });

        return $transformedCampaigns->toArray();
    }
}

