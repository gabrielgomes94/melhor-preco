<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\CreatePriceCampaignRequest;
use App\Http\Transformers\Pricing\CreatePricingTransformer as Transformer;
use Barrigudinha\Pricing\Services\CreatePricing as Service;

class CreatePricingController extends Controller
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
        return view('pricing.create');
    }

    public function store(CreatePriceCampaignRequest $request)
    {
        $createPricingData = $this->transformer->transform($request);
        $pricing = $this->pricingService->create($createPricingData);

        return redirect(route('pricing.list'));
    }
}
