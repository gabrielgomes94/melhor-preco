<?php

namespace Src\Products\Presentation\Presenters;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\Item;

class ProductPresenter
{
    public function present(array $data)
    {
        dd($data);
        return [
            'costs' => $data['costs'],
            'product' => $data['product']->toArray(),
            'sales' => [
                'total' => $data['sales']['total'],
                'salesByMarketplace' => $this->presentSalesByMarketplace($data['sales']['salesByMarketplace']),
            ],
        ];
    }

    private function presentSalesByMarketplace(array $sales): array
    {
//        return $sales->map(function (Item $saleItem) {
//            return [
//                'quantity' => $sales->count(),
//                'value' => $sales->sum(function(Item $saleItem) {
//                    return $saleItem->getTotalValue();
//                }),
//                'slug' => $marketplaceSlug,
//                'storeName' => $marketplace->getName(),
//            ];
//        })->all();
    }
}
