<?php

namespace Src\Prices\Price\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\Store\Factory;

class PriceListPresenter
{
    private Breadcrumb $breadcrumb;

    public function __construct(
        Breadcrumb $breadcrumb
    ) {
        $this->breadcrumb = $breadcrumb;
    }

    public function list(LengthAwarePaginator $paginator, string $store, array $parameters)
    {
        $store = new StorePresenter(
            name: Factory::make($store)->getName(),
            slug: $store
        );

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

    private function getBreadcrumb(StorePresenter $store): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug())
        );
    }
}
