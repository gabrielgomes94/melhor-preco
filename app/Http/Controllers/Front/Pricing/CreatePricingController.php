<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Requests\Pricing\CreatePriceCampaignRequest;
use App\Http\Transformers\Pricing\CreatePricingTransformer as Transformer;
use Barrigudinha\Pricing\Services\CreatePricing as Service;


class CreatePricingController
{
    private Transformer $transformer;

    private Service $pricingService;

    public function __construct(Transformer $transformer, Service $pricingService)
    {
        $this->transformer = $transformer;
        $this->pricingService = $pricingService;
    }

    public function create()
    {
        return view('pricing.campaign.create');
    }

    public function store(CreatePriceCampaignRequest $request)
    {
        $data = $this->transformer->transform($request);
        $pricing = $this->pricingService->create($data);

        dd($pricing);


        return view('pricing.campaign.create');
    }
}
