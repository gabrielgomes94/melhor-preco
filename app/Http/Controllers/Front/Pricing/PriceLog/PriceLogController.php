<?php

namespace App\Http\Controllers\Front\Pricing\PriceLog;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Presenters\Store\Presenter;
use App\Repositories\Pricing\PriceLog\ListDB;
use App\Repositories\Product\Options\Options;
use App\Repositories\Store\Store;
use Illuminate\Http\Request;

class PriceLogController extends Controller
{
    private Breadcrumb $breadcrumb;
    private ListDB $repository;
    private Presenter $storePresenter;

    public function __construct(Breadcrumb $breadcrumb, ListDB $repository, Presenter $storePresenter)
    {
        $this->breadcrumb = $breadcrumb;
        $this->repository = $repository;
        $this->storePresenter = $storePresenter;
    }

    public function lastUpdatedProducts(string $storeSlug, Request $request)
    {
        $options = new Options([
            'page' => 1,
            'store' => $storeSlug,
        ]);

        $products = $this->repository->list($options);
        $store = $this->storePresenter->present($storeSlug);
        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug()),
            [
                'link' => '',
                'name' => 'Histórico de Atualizações',
            ]
        );

        return view('pages.pricing.price-log.last-updated-products', [
            'breadcrumb' => $breadcrumb,
            'products' => $products,
            'store' => $store,
        ]);
    }
}
