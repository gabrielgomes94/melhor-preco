<?php

namespace Src\Prices\Application\Http\Controllers\Web\PriceLog;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use Src\Prices\Application\Http\Requests\PriceLog\PriceLogRequest;
use App\Presenters\Store\Presenter;
use App\Presenters\Store\Store;
use Src\Prices\Application\Services\ListProducts;
use Illuminate\Pagination\LengthAwarePaginator;

class PriceLogController extends Controller
{
    private Breadcrumb $breadcrumb;
    private Presenter $storePresenter;
    private \Src\Prices\Application\Services\ListProducts $listProductsService;

    public function __construct(Breadcrumb $breadcrumb, Presenter $storePresenter, \Src\Prices\Application\Services\ListProducts $listProductsService)
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
