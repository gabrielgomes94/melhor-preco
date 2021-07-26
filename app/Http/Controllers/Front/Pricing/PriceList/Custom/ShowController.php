<?php

namespace App\Http\Controllers\Front\Pricing\PriceList\Custom;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Http\Controllers\Utils\Paginator;
use App\Presenters\Pricing\Product\Presenter as ProductPresenter;
use App\Presenters\Pricing\Show as PricingShow;
use App\Presenters\Store\Presenter as StorePresenter;
use App\Repositories\Pricing\PriceListRepository;
use Barrigudinha\Pricing\PriceList\PriceList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowController extends Controller
{
    private PriceListRepository $repository;
    private PricingShow $presenter;
    private StorePresenter $storePresenter;
    private ProductPresenter $productPresenter;
    private Paginator $paginator;
    private Breadcrumb $breadcrumb;

    public function __construct(
        PriceListRepository $repository,
        PricingShow $presenter,
        StorePresenter $storePresenter,
        ProductPresenter $productPresenter,
        Paginator $paginator,
        Breadcrumb $breadcrumb
    ) {
        $this->repository = $repository;
        $this->presenter = $presenter;
        $this->storePresenter = $storePresenter;
        $this->productPresenter = $productPresenter;
        $this->paginator = $paginator;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function show(string $id, Request $request)
    {
        if (!$priceList = $this->repository->get($id)) {
            abort(404);
        }

        $products = $this->productPresenter->list($priceList->products());
        $paginator = $this->paginator->paginate($products, $request);

        return view('pages.pricing.price-list.custom.show', $this->getViewData($priceList, $paginator));
    }

    private function getViewData(PriceList $priceList, LengthAwarePaginator $paginator): array
    {
        $stores = $this->storePresenter->list($priceList->stores());
        $breadcrumb = $this->generateBreadcrumb($priceList);

        return [
            'breadcrumb' => $breadcrumb,
            'priceList' => $priceList,
            'paginator' => $paginator,
            'products' => $paginator->items(),
            'stores' => $stores,
        ];
    }

    private function generateBreadcrumb(PriceList $priceList): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListCustom($priceList),
        );
    }
}
