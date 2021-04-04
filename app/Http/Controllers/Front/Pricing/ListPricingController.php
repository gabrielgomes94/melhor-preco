<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Presenters\Pricing\PricingList;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;

class ListPricingController
{
    private PricingRepository $repository;
    private PricingList $presenter;

    public function __construct(PricingRepository $repository, PricingList $presenter)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;
    }

    public function list()
    {
        $pricing = $this->repository->all();
        $pricingList = $this->presenter->present($pricing);

        return view('pricing.campaign.list', compact('pricingList'));
    }
}
