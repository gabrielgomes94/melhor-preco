<?php

namespace App\Services\Sales;

use Src\Products\Infrastructure\Repositories\GetDB;
use App\Repositories\Store\Store;
use Src\Prices\Domain\Price\Services\CalculatePrice;
use Barrigudinha\SaleOrder\Entities\SaleOrder;
use Barrigudinha\SaleOrder\Entities\SaleOrdersCollection;
use Barrigudinha\SaleOrder\ValueObjects\Item;
use Barrigudinha\Utils\Helpers;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class Service
{
    private GetDB $productRepository;
    private Store $storeRepository;
    private CalculatePrice $calculatePrice;

    public function __construct(GetDB $productRepository, Store $storeRepository, CalculatePrice $calculatePrice)
    {
        $this->productRepository = $productRepository;
        $this->storeRepository = $storeRepository;
        $this->calculatePrice = $calculatePrice;
    }

    public function listSaleOrder(SaleOrdersCollection $saleOrdersCollection): array
    {
        $sales = [];

        /**
         * @var SaleOrder $saleOrder
         */
        foreach ($saleOrdersCollection as $saleOrder) {
            if (!$saleOrder->identifiers()->storeId()) {
                continue;
            }

            $products = [];

            foreach($saleOrder->items() as $item) {
                if (!$product = $this->productRepository->get($item->sku())) {
                    continue;
                }

                $products[] = "{$product->sku()} - {$product->name()}";
            }

            $saleOrdersTransformed[] = [
                'saleOrderCode' => $saleOrder->identifiers()->id(),
                'purchaseSaleOrderId' => $saleOrder->identifiers()->purchaseSaleOrderId(),
                'storeSaleOrderId' => $saleOrder->identifiers()->storeSaleOrderId(),
                'selledAt' => $saleOrder->saleDates()->selledAt()->format('d-m-Y'),
                'store' => $this->storeRepository->getNameFromCode(
                    $saleOrder->identifiers()->storeId()
                ),
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
         * @var Item $item
         */
        foreach ($saleOrder->items() as $item) {
            $product = $this->productRepository->get($item->sku());

            if (!$product) {
                continue;
            }

            $slug = $this->storeRepository->getSlugFromCode(
                $saleOrder->identifiers()->storeId()
            );

            if (!$slug) {
                continue;
            }

            $store = $product->getPost($slug)?->store();

            if (!$store) {
                continue;
            }

            $unitValue = Helpers::floatToMoney($item->unitValue());
            $discount = Helpers::floatToMoney($item->discount());

            $value = $unitValue->subtract($discount);
            $price = $this->calculatePrice->calculate($product, $store, $value);
            $profit = $profit->add(
                $price->profit()->multiply(
                    $item->quantity()
                )
            );
        }

        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return (float) $moneyFormatter->format($profit);
    }

    private function getTotalValues(array $saleOrders): array
    {
        $totalValue = Money::BRL(0);
        $totalProfit = Money::BRL(0);

        foreach ($saleOrders as $saleOrder) {
            $totalValue = $totalValue->add(Helpers::floatToMoney($saleOrder['value']));
            $totalProfit = $totalProfit->add(Helpers::floatToMoney($saleOrder['profit']));
        }

        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'value' => (float) $moneyFormatter->format($totalValue),
            'profit' => (float) $moneyFormatter->format($totalProfit),
        ];
    }
}
