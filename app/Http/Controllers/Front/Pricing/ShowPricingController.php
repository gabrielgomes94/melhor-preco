<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Presenters\Pricing\Show as Presenter;
use App\Http\Transformers\Pricing\CampaignTransformer;
use Barrigudinha\Pricing\Repositories\Contracts\CampaignRepository;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;
use Barrigudinha\Pricing\Services\CreatePricing;
use Illuminate\Routing\Controller as BaseController;

class ShowPricingController extends BaseController
{
    private PricingRepository $repository;
    private CampaignTransformer $transformer;
    private CreatePricing $pricingService;
    private Presenter $presenter;

    public function __construct(PricingRepository $repository, CampaignTransformer $transformer, CreatePricing $pricingService, Presenter $presenter)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->pricingService = $pricingService;
        $this->presenter = $presenter;
    }

    public function list()
    {
        $campaigns = $this->repository->all();
        $campaigns = $this->transformer->list($campaigns);

        return view('pricing.campaign.list', compact('campaigns'));
    }

    public function show(string $id)
    {
        $campaign = $this->repository->find($id);
        $campaign = $this->presenter->present($campaign);

        return view('pricing.campaign.show', ['pricing' => $campaign->toArray()]);
    }
}
