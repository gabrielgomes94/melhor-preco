<?php

namespace App\Http\Controllers\Front\Pricing\PriceList;

use App\Http\Controllers\Controller;
use App\Presenters\Pricing\Show as PricingShow;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    private PricingRepository $repository;
    private PricingShow $presenter;

    public function __construct(PricingRepository $repository, PricingShow $presenter)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function show(string $id)
    {
        if (!$pricing = $this->repository->find($id)) {
            abort(404);
        }

        $presentationPricing = $this->presenter->present($pricing);

        return view('pages.pricing.show', ['pricing' => $presentationPricing]);
    }
}
