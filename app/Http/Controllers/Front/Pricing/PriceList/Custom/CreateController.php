<?php

namespace App\Http\Controllers\Front\Pricing\PriceList\Custom;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\CreatePriceCampaignRequest;
use App\Http\Transformers\Pricing\CreatePricingTransformer as Transformer;
use Barrigudinha\Pricing\Services\CreatePricing as Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CreateController extends Controller
{
    private Transformer $transformer;
    private Service $pricingService;

    public function __construct(Transformer $transformer, Service $pricingService)
    {
        $this->transformer = $transformer;
        $this->pricingService = $pricingService;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function create()
    {
        return view('pages.pricing.price-list.custom.create');
    }

    /**
     * @return Redirector|RedirectResponse
     */
    public function store(CreatePriceCampaignRequest $request)
    {
        $createPricingData = $this->transformer->transform($request);
        $this->pricingService->create($createPricingData);

        return redirect(route('pricing.priceList.index'));
    }
}
