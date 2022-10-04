<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters\SalesList;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Transformers\NumberTransformer;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Domain\Models\ValueObjects\SaleIdentifiers;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

class SalesListPresenter
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly ProductRepository $productRepository
    ) {
    }

    public function listSaleOrder(SaleOrdersCollection $saleOrders, string $userId): array
    {
        /**
         * @var SaleOrder $saleOrder
         */
        foreach ($saleOrders->get() as $saleOrder) {
            $identifiers = $saleOrder->getIdentifiers();
            $saleValue = $saleOrder->getSaleValue();
            $products = $this->presentProducts($saleOrder, $userId);

            $presented[] = [
                'saleOrderCode' => $identifiers->saleOrderId(),
                'storeSaleOrderId' => $identifiers->storeSaleOrderId(),
                'selledAt' => $this->presentSelledAt($saleOrder),
                'store' => $this->presentStore($identifiers, $userId),
                'value' => NumberTransformer::toMoney($saleValue->totalValue()),
                'products' => $products,
                'productsInTooltip' => $this->presentProductsInTooltip($products),
                'productsValue' => $saleValue->totalProducts(),
                'profit' => $this->getProfit($saleOrder),
                'status' => (string) $saleOrder->getStatus(),
            ];
        }

        return $presented ?? [];
    }

    private function presentProducts(SaleOrder $saleOrder, string $userId): array
    {
        /**
         * @var Item $item
         */
        foreach ($saleOrder->getItems() as $item) {
            $product = $this->productRepository->get($item->getSku(), $userId);

            if (!$product) {
                continue;
            }

            for ($i = 0; $i < $item->getQuantity(); $i++) {
                $presented[] = [
                    'formattedName' => "{$product->getSku()} - {$product->getName()}",
                    'sku' => $product->getSku(),
                ];
            }
        }

        return $presented ?? [];
    }

    private function presentSelledAt(SaleOrder $saleOrder): string
    {
        return $saleOrder->getSaleDates()->selledAt()->format('d/m/Y');
    }

    private function presentStore(SaleIdentifiers $identifiers, string $userId): string
    {
        $marketplace = $this->marketplaceRepository->getByErpId(
            $identifiers->storeId(),
            $userId
        );

        if (!$marketplace) {
            return '';
        }

        return $marketplace->getName();
    }

    private function getProfit(SaleOrder $saleOrder): string
    {
        $profit = $saleOrder->getProfit();

        return $profit
            ? NumberTransformer::toMoney($profit)
            : '';
    }

    private function presentProductsInTooltip(array $products): string
    {
        return implode(
            ';',
            array_column($products, 'formattedName')
        );
    }
}
