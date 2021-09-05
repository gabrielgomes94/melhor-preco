<?php

namespace App\Http\Controllers\Front\Pricing\PriceLog;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Http\Requests\Pricing\PriceLog\PriceLogRequest;
use App\Presenters\Store\Presenter;
use App\Presenters\Store\Store;
use App\Services\Pricing\PriceLog\ListProducts;
use Illuminate\Pagination\LengthAwarePaginator;

class PriceLogController extends Controller
{
    private Breadcrumb $breadcrumb;
    private Presenter $storePresenter;
    private ListProducts $listProductsService;

    public function __construct(Breadcrumb $breadcrumb, Presenter $storePresenter, ListProducts $listProductsService)
    {
        $this->breadcrumb = $breadcrumb;
        $this->storePresenter = $storePresenter;
        $this->listProductsService = $listProductsService;
    }

    public function lastUpdatedProducts(string $storeSlug, PriceLogRequest $request)
    {
        $options = $request->getOptions();
        $options->setStore($storeSlug);

        $products = $this->listProductsService->listPaginate($options);

        return view('pages.pricing.price-log.last-updated-products', $this->viewData($storeSlug, $products));
    }

    private function getBreadcrumb(Store $store): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug()),
            [
                'link' => '',
                'name' => 'Histórico de Atualizações',
            ]
        );
    }

    private function viewData(string $storeSlug, LengthAwarePaginator $paginator): array
    {
        $store = $this->storePresenter->present($storeSlug);
        $breadcrumb = $this->getBreadcrumb($store);

        return [
            'breadcrumb' => $breadcrumb,
            'products' => $paginator->items(),
            'paginator' => $paginator,
            'store' => $store,
        ];
    }
}
