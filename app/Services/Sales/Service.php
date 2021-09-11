<?php

namespace App\Services\Sales;

use App\Repositories\Product\GetDB;
use App\Repositories\Store\Store;
use Barrigudinha\SaleOrder\Entities\SaleOrder;
use Barrigudinha\SaleOrder\Entities\SaleOrdersCollection;

class Service
{
    private GetDB $finderDB;
    private Store $storeRepository;

    public function __construct(GetDB $finderDB, Store $storeRepository)
    {
        $this->finderDB = $finderDB;
        $this->storeRepository = $storeRepository;
    }

    public function listSaleOrder(SaleOrdersCollection $saleOrders): array
    {
        $sales = [];

        /**
         * @var SaleOrder $saleOrder
         */
        foreach ($saleOrders as $saleOrder) {
            $skus = [];

            foreach($saleOrder->items() as $item) {
                $skus[] = $item->sku();
            }

            $sales[] = [
                'saleOrderCode' => $saleOrder->identifiers()->id(),
                'selledAt' => (string) $saleOrder->saleDates()->selledAt(),
                'store' => $this->storeRepository->getNameFromCode(
                    $saleOrder->identifiers()->storeId()
                ),
                'status' => (string) $saleOrder->status(),
                'skus' => implode(',', $skus ?? []),
                'totalValue' => $saleOrder->saleValue()->totalValue(),
                'profit' => 0.0,
            ];
        }

        return $sales ?? [];
    }

    private function getProfit(): float
    {
        return 0.0;
    }
}
