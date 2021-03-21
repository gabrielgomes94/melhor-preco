<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Transformers\Pricing\CampaignTransformer;
use Barrigudinha\Pricing\Repositories\Contracts\CampaignRepository;
use Barrigudinha\Pricing\Services\CreatePricing;
use Illuminate\Routing\Controller as BaseController;

class ShowPricingController extends BaseController
{
    private CampaignTransformer $transformer;
    private CampaignRepository $repository;
    private CreatePricing $pricingService;

    public function __construct(CampaignRepository $repository, CampaignTransformer $transformer, CreatePricing $pricingService)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->pricingService = $pricingService;
    }

    public function list()
    {
        $campaigns = $this->repository->all();
        $campaigns = $this->transformer->list($campaigns);

        return view('pricing.campaign.list', compact('campaigns'));
    }

    public function show($id)
    {
        return view('pricing.campaign.show');
    }
}
