<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Presenters\Pricing\Show as PricingShow;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;
use Illuminate\Routing\Controller as BaseController;

class ShowPricingController extends BaseController
{
    private PricingRepository $repository;
    private PricingShow $presenter;

    public function __construct(PricingRepository $repository, PricingShow $presenter)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;
    }

    public function show(string $id)
    {
        if (!$pricing = $this->repository->find($id)) {
            abort(404);
        }

        $presentationPricing = $this->presenter->present($pricing);

        return view('pricing.show', ['pricing' => $presentationPricing]);
    }
}
