<?php

namespace Src\Prices\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;

class PriceLogPresenter
{
    private Breadcrumb $breadcrumb;

    public function __construct(Breadcrumb $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }

    public function list(LengthAwarePaginator $paginator, string $storeSlug): array
    {
        $store = new StorePresenter(
            name: $storeSlug,
            slug: $storeSlug
        );
        $products = $this->present($paginator->items());

        return [
            'breadcrumb' => $this->getBreadcrumb($store),
            'products' => $products,
            'paginator' => $paginator,
            'store' => $store,
        ];
    }

    private function getBreadcrumb(StorePresenter $store): array
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

    private function present(array $products): array
    {
        foreach ($products as $product) {
            $data = $product->toArray();

            $productsPresenter[] = [
                'sku' => $data['sku'],
                'name' => $data['name'],
                'value' => $data['value'],
                'profit' => $data['profit'],
                'updated_at' => $product->updated_at->format('d/m/Y'),
            ];
        }

        return $productsPresenter ?? [];
    }
}
