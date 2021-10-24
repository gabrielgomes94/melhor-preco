<?php

namespace Src\Prices\Price\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use App\Presenters\Store\Presenter as StorePresenter;
use App\Presenters\Store\Store;
use Illuminate\Pagination\LengthAwarePaginator;

class PriceListPresenter
{
    private Breadcrumb $breadcrumb;
    private StorePresenter $storePresenter;

    public function __construct(
        StorePresenter $storePresenter,
        Breadcrumb $breadcrumb
    ) {
        $this->breadcrumb = $breadcrumb;
        $this->storePresenter = $storePresenter;
    }

    public function list(LengthAwarePaginator $paginator, string $store, array $parameters)
    {
        $store = $this->storePresenter->present($store);

        return [
            'breadcrumb' => $this->getBreadcrumb($store),
            'paginator' => $paginator,
            'products' => $paginator->items(),
            'minimumProfit' => $parameters['minProfit'] ?? null,
            'maximumProfit' => $parameters['maxProfit'] ?? null,
            'sku' => $parameters['sku'] ?? null,
            'store' => $store,
        ];
    }

    private function getBreadcrumb(Store $store): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug())
        );
    }
}
