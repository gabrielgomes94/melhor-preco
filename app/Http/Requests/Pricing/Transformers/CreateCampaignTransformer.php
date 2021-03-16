<?php
namespace App\Http\Requests\Pricing\Transformers;

use App\Http\Requests\Pricing\Data\CreateCampaign;
use App\Http\Requests\Pricing\CreatePriceCampaignRequest;

class CreateCampaignTransformer
{
    public function transform(CreatePriceCampaignRequest $request): CreateCampaign
    {
        $skuList = explode(' ', $request->input('skus'));

        return new CreateCampaign([
            'name' => $request->input('name'),
            'skuList' => $skuList,
            'stores' => $request->input('stores'),
        ]);
    }
}
