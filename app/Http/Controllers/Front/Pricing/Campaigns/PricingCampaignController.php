<?php

namespace App\Http\Controllers\Front\Pricing\Campaigns;

use App\Http\Transformers\Pricing\CampaignTransformer;
use Barrigudinha\Pricing\Repositories\Contracts\CampaignRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PricingCampaignController extends BaseController
{
    private CampaignTransformer $transformer;

    private CampaignRepository $repository;

    public function __construct(CampaignRepository $repository, CampaignTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    public function list()
    {
        $campaigns = $this->repository->all();
        $campaigns = $this->transformer->list($campaigns);

        return view('pricing.campaign.list', compact('campaigns'));
    }

    public function create()
    {
        return view('pricing.campaign.create');
    }

    public function store(Request $request)
    {
        $skus = $request->input('skus');
        $skus = explode(' ', $skus);

        dd($skus);
    }
}
