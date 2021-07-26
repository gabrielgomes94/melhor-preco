<?php

namespace App\Http\Controllers\Front\Pricing\PriceList\ByStore;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Http\Controllers\Utils\Paginator;
use App\Presenters\Pricing\Product\Presenter as ProductPresenter;
use App\Presenters\Store\Presenter as StorePresenter;
use App\Presenters\Store\Store;
use App\Repositories\Product\FinderDB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowController extends Controller
{
    private FinderDB $productRepository;
    private StorePresenter $storePresenter;
    private ProductPresenter $productPresenter;
    private Paginator $paginator;
    private Breadcrumb $breadcrumb;

    public function __construct(
        FinderDB $productRepository,
        StorePresenter $storePresenter,
        ProductPresenter $productPresenter,
        Paginator $paginator,
        Breadcrumb $breadcrumb
    ) {
        $this->productRepository = $productRepository;
        $this->storePresenter = $storePresenter;
        $this->productPresenter = $productPresenter;
        $this->paginator = $paginator;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return Application|Factory|View
     */
    public function show(string $store, Request $request)
    {
        $products = $this->productRepository->allByStore($store);
        $store = $this->storePresenter->present($store);
        $productsPresented = $this->productPresenter->list($products, $store->slug());
        $paginator = $this->paginator->paginate($productsPresented, $request);

        return view('pages.pricing.price-list.stores.show', $this->viewData($store, $paginator));
    }

    private function getBreadcrumb(Store $store): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug())
        );
    }

    private function viewData(Store $store, LengthAwarePaginator $paginator): array
    {
        return [
            'store' => $store,
            'breadcrumb' => $this->getBreadcrumb($store),
            'paginator' => $paginator,
            'products' => $paginator->items(),
        ];
    }
}
