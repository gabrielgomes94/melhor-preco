<?php

namespace App\Http\Controllers\Front\Pricing\PriceList;

use App\Http\Controllers\Controller;
use App\Presenters\Pricing\PricingList;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ListController extends Controller
{
    private PricingRepository $repository;
    private PricingList $presenter;

    public function __construct(PricingRepository $repository, PricingList $presenter)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function index()
    {
        return view('pages.pricing.price-list.index');
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function list()
    {
        $pricing = $this->repository->all();
        $pricingList = $this->presenter->present($pricing);

        return view('pages.pricing.price-list.custom.list', compact('pricingList'));
    }
}
