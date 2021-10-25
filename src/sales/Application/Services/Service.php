<?php

namespace Src\Sales\Application\Services;

use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Product\Models\Product;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\SaleOrdersCollection;
use Src\Sales\Domain\Models\Data\Item;
use Src\Prices\Calculator\Domain\Transformer\PercentageTransformer;
use Money\Money;
use Src\Products\Domain\Store\Factory;

class Service
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function listSaleOrder(SaleOrdersCollection $saleOrdersCollection): array
    {
        $sales = [];

        /**
         * @var \Src\Sales\Domain\Models\SaleOrder $saleOrder
         */
        foreach ($saleOrdersCollection as $saleOrder) {
            if (!$saleOrder->identifiers()->storeId()) {
                continue;
            }

            $products = [];

            foreach ($saleOrder->items() as $item) {
                if (!$product = Product::find($item->sku())) {
                    continue;
                }

                $product = $product->data();

                $products[] = "{$product->getSku()} - {$product->getDetails()->getName()}";
            }

            $saleOrdersTransformed[] = [
                'saleOrderCode' => $saleOrder->identifiers()->id(),
                'purchaseSaleOrderId' => $saleOrder->identifiers()->purchaseSaleOrderId(),
                'storeSaleOrderId' => $saleOrder->identifiers()->storeSaleOrderId(),
                'selledAt' => $saleOrder->saleDates()->selledAt()->format('d-m-Y'),
                'store' => Factory::makeFromErpCode($saleOrder->identifiers()->storeId())->getName(),
                'status' => (string) $saleOrder->status(),
                'products' => $products,
                'value' => $saleOrder->saleValue()->totalValue(),
                'productsValue' => $saleOrder->saleValue()->totalProducts(),
                'profit' => $this->getProfit($saleOrder),
            ];
        }

        $sales = [
            'saleOrders' => $saleOrdersTransformed,
            'total' => $this->getTotalValues($saleOrdersTransformed),
        ];

        return $sales ?? [];
    }

    private function getProfit(SaleOrder $saleOrder): float
    {
        $profit = Money::BRL(0);

        /**
         * @var \Src\Sales\Domain\Models\Data\Item $item
         */
        foreach ($saleOrder->items() as $item) {
            $product = Product::find($item->sku());

            if (!$product) {
                continue;
            }

            $product = $product->data();

            $store = Factory::makeFromErpCode($saleOrder->identifiers()->storeId());

            if (!$slug = $store->getSlug()) {
                continue;
            }

            $store = $product->getPost($slug)?->getStore();

            if (!$store) {
                continue;
            }

            $unitValue = MoneyTransformer::toMoney($item->unitValue());
            $discount = MoneyTransformer::toMoney($item->discount());
            $commission = $product->getPost($slug)->getPrice()->getCommission()->getCommissionRate();

            $value = $unitValue->subtract($discount);
            $price = $this->calculatePrice->calculate(
                new ProductData(costs: $product->getCosts(), dimensions: $product->getDimensions()),
                $store,
                MoneyTransformer::toFloat($value),
                $commission
            );

            $profit = $profit->add(
                $price->getProfit()->multiply($item->quantity())
            );
        }

        return MoneyTransformer::toFloat($profit);
    }

    private function getTotalValues(array $saleOrders): array
    {
        $totalValue = Money::BRL(0);
        $totalProfit = Money::BRL(0);

        foreach ($saleOrders as $saleOrder) {
            $totalValue = $totalValue->add(MoneyTransformer::toMoney($saleOrder['value']));
            $totalProfit = $totalProfit->add(MoneyTransformer::toMoney($saleOrder['profit']));
        }

        return [
            'value' => MoneyTransformer::toFloat($totalValue),
            'profit' => MoneyTransformer::toFloat($totalProfit),
        ];
    }
}
