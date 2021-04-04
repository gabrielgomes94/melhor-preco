<?php

namespace App\Http\Transformers\Pricing;

use App\Http\Requests\Pricing\CreatePriceCampaignRequest;
use App\Http\Transformers\Pricing\Data\CreatePricing;

class CreatePricingTransformer
{
    public function transform(CreatePriceCampaignRequest $request): CreatePricing
    {
        $skus = $request->input('skus');
        $skus = explode(' ', $skus);

        return new CreatePricing(
            name: $request->input('name'),
            products: $skus,
            stores: $request->input('stores'),
        );
    }
}
