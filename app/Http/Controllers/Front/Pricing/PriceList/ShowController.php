<?php

namespace App\Http\Controllers\Front\Pricing\PriceList;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Http\Controllers\Utils\Paginator;
use App\Presenters\Pricing\Product\Presenter as ProductPresenter;
use App\Presenters\Pricing\Show as PricingShow;
use App\Presenters\Store\Presenter as StorePresenter;
use App\Repositories\Pricing\PriceListRepository;
use App\Repositories\Product\FinderDB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    private PriceListRepository $repository;
    private PricingShow $presenter;
    private FinderDB $productRepository;
    private StorePresenter $storePresenter;
    private ProductPresenter $productPresenter;
    private Paginator $paginator;
    private Breadcrumb $breadcrumb;

    public function __construct(
        PriceListRepository $repository,
        PricingShow $presenter,
        FinderDB $productRepository,
        StorePresenter $storePresenter,
        ProductPresenter $productPresenter,
        Paginator $paginator,
        Breadcrumb $breadcrumb
    ) {
        $this->repository = $repository;
        $this->presenter = $presenter;
        $this->productRepository = $productRepository;
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

        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListCustom($priceList),
        );

        $products = $this->productPresenter->list($priceList->products());

        $paginator = $this->paginator->paginate($products, $request);
        $stores = $this->storePresenter->list($priceList->stores());

        return view('pages.pricing.price-list.custom.show', [
            'breadcrumb' => $breadcrumb,
            'priceList' => $priceList,
            'paginator' => $paginator,
            'products' => $paginator->items(),
            'stores' => $stores,
        ]);
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function byStore(string $store, Request $request)
    {
        $products = $this->productRepository->allByStore($store);
        $store = $this->storePresenter->present($store);
        $productsPresented = $this->productPresenter->list($products, $store->slug());

        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug())
        );

        $paginator = $this->paginator->paginate($productsPresented, $request);

        return view('pages.pricing.price-list.stores.show', [
            'store' => $store,
            'breadcrumb' => $breadcrumb,
            'paginator' => $paginator,
            'products' => $paginator->items(),
        ]);
    }
}
