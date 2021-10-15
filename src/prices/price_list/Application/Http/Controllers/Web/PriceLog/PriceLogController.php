<?php

namespace Src\Prices\PriceList\Application\Http\Controllers\Web\PriceLog;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use Src\Prices\PriceList\Application\Http\Requests\PriceLog\PriceLogRequest;
use App\Presenters\Store\Presenter;
use App\Presenters\Store\Store;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Prices\PriceList\Application\Services\PriceLog\ListProducts;

class PriceLogController extends Controller
{
    private Breadcrumb $breadcrumb;
    private Presenter $storePresenter;
    private \Src\Prices\PriceList\Application\Services\PriceLog\ListProducts $listProductsService;

    public function __construct(Breadcrumb $breadcrumb, Presenter $storePresenter, ListProducts $listProductsService)
    {
        $this->breadcrumb = $breadcrumb;
        $this->storePresenter = $storePresenter;
        $this->listProductsService = $listProductsService;
    }

    /**
     * To Do: refactor get Options
     * @param string $storeSlug
     * @param PriceLogRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function lastUpdatedProducts(string $storeSlug, \Src\Prices\PriceList\Application\Http\Requests\PriceLog\PriceLogRequest $request)
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
