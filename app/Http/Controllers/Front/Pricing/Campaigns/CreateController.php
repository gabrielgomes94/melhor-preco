<?php

namespace App\Http\Controllers\Front\Pricing\Campaigns;

use App\Http\Requests\Pricing\CreatePriceCampaignRequest;
use App\Http\Requests\Pricing\Transformers\CreateCampaignTransformer;
use Illuminate\Routing\Controller as BaseController;

class CreateController extends BaseController
{
    private CreateCampaignTransformer $transformer;

    public function __construct(CreateCampaignTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function create()
    {
        return view('pricing.campaign.create');
    }

    public function store(CreatePriceCampaignRequest $request)
    {
        $pricing = $this->transformer->transform($request);

        dd($pricing);

        return view('pricing.campaign.create');
    }
}
