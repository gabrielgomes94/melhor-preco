<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Prices\Calculator\Domain\Models\Product\ProductData;
use Src\Prices\Calculator\Domain\Services\Contracts\CalculateItem as CalculateItemInterface;
use Src\Products\Domain\Models\Store\Store;
use Src\Products\Infrastructure\Config\StoreRepository;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Models\SaleOrder;

class CalculateItem implements CalculateItemInterface
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function calculate(Item $item): Price
    {
        $store = $this->getStore($item->saleOrder);

        return $this->calculatePrice->calculate(
            productData: ProductData::fromModel($item->product),
            store: $store,
            value: $item->getTotalValue(),
            commission: Percentage::fromPercentage($store->getDefaultCommission())
        );
    }

    private function getStore(?SaleOrder $saleOrder): Store
    {
        return $saleOrder
            ? $saleOrder->getStore()
            : StoreRepository::getDefault();
    }
}
