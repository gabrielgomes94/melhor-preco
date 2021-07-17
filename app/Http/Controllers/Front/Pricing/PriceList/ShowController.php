<?php

namespace App\Http\Controllers\Front\Pricing\PriceList;

use App\Http\Controllers\Controller;
use App\Presenters\Pricing\Product\Presenter as ProductPresenter;
use App\Presenters\Pricing\Show as PricingShow;
use App\Presenters\Store\Presenter as StorePresenter;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;
use Barrigudinha\Pricing\Services\PriceCalculator\CalculateList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    private PricingRepository $repository;
    private PricingShow $presenter;
    private FinderDB $productRepository;
    private StorePresenter $storePresenter;
    private ProductPresenter $productPresenter;
    private CalculateList $calculateListService;

    public function __construct(
        PricingRepository $repository,
        PricingShow $presenter,
        FinderDB $productRepository,
        StorePresenter $storePresenter,
        ProductPresenter $productPresenter,
        CalculateList $calculateListService
    ) {
        $this->repository = $repository;
        $this->presenter = $presenter;
        $this->productRepository = $productRepository;
        $this->storePresenter = $storePresenter;
        $this->productPresenter = $productPresenter;
        $this->calculateListService = $calculateListService;
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
        $breadcrumb = [
            [
                'link' => route('pricing.priceList.index'),
                'name' => 'Listas de Preços',
            ],
        ];

        return view('pages.pricing.price-list.custom.show', [
            'breadcrumb' => $breadcrumb,
            'pricing' => $presentationPricing
        ]);
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function byStore(string $store)
    {
        $products = $this->productRepository->allByStore($store);
        $productsPriced = $this->calculateListService->execute($products, $store);

        $store = $this->storePresenter->present($store);
        $productsPresented = $this->productPresenter->list($products, $store->slug);
        $breadcrumb = [
            [
                'link' => route('pricing.priceList.index'),
                'name' => 'Listas de Preços',
            ],
            [
                'link' => route('pricing.priceList.byStore', $store->slug),
                'name' => $store->name,
            ],
        ];

        return view('pages.pricing.price-list.stores.show', [
            'store' => $store,
            'products' => $productsPresented,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}
