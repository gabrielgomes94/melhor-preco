<?php

namespace Src\Sales\Application\Services;

use Money\Money;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Products\Domain\Product\Models\Product;
use Src\Products\Domain\Store\Factory;
use Src\Products\Domain\Store\Store;
use Src\Sales\Domain\Models\ValueObjects\Items\Item;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Services\Contracts\CalculateTotalProfit as CalculateTotalProfitInterface;

class CalculateTotalProfit implements CalculateTotalProfitInterface
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function execute(SaleOrder $saleOrder): float
    {
        foreach ($saleOrder->getItems() as $item) {
            $product = Product::find($item->sku());

            if (!$product) {
                continue;
            }

            if (!$store = $this->getStore($saleOrder, $product)) {
                continue;
            }

            $product = $product->data();

            $price = $this->calculatePrice->calculate(
                $this->getProductData($product),
                $store,
                $this->getValue($item),
                $this->getCommission($product, $store)
            );

            $profit = $profit->add(
                $price->getProfit()->multiply($item->quantity())
            );
        }

        return MoneyTransformer::toFloat($profit ?? Money::BRL(0));
    }

    // To Do: Refatorar esse método para usar a model ao invés desse Data
    private function getCommission(\Src\Products\Domain\Product\Models\Data\ProductData $product, Store $store)
    {
        return $product->getPost($store->getSlug())
            ->getPrice()
            ->getCommission()
            ->getCommissionRate();
    }

    private function getProductData($product): ProductData
    {
        return new ProductData(
            costs: $product->getCosts(),
            dimensions: $product->getDimensions()
        );
    }

    private function getStore(SaleOrder $saleOrder, Product $product): ?Store
    {
        $store = Factory::makeFromErpCode(
            $saleOrder->getIdentifiers()->storeId() ?? ''
        );

        if (!$store) {
            return null;
        }

        if (!$slug = $store->getSlug()) {
            return null;
        }

        $store = $product->data()
            ->getPost($slug)
            ?->getStore();

        if (!$store) {
            return null;
        }

        return $store;
    }

    private function getValue(Item $item): float
    {
        $unitValue = MoneyTransformer::toMoney($item->unitValue());
        $discount = MoneyTransformer::toMoney($item->discount());
        $value = $unitValue->subtract($discount);

        return MoneyTransformer::toFloat($value);
    }
}
