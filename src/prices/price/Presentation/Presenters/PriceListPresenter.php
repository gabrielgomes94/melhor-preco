<?php

namespace Src\Prices\Price\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use App\Presenters\Store\Presenter as StorePresenter;
use App\Presenters\Store\Store;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\Entities\ProductsCollection;

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
        $productsCollection = new ProductsCollection($paginator->items());

        return [
            'breadcrumb' => $this->getBreadcrumb($store),
            'paginator' => $paginator,
            'products' => $productsCollection,
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
