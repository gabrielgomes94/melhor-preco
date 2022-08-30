<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Money\Money;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\Models\Contracts\SaleOrder;
use Src\Sales\Domain\Services\CalculateTotalProfit as CalculateTotalProfitInterface;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class CalculateTotalProfit implements CalculateTotalProfitInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly ProductRepository $productRepository,
        private readonly FreightRepository $freightRepository,
        private readonly CommissionRepository $commissionRepository,
    ) {
    }

    public function execute(SaleOrder $saleOrder, string $userId): float
    {
        $marketplace = $this->marketplaceRepository->getByErpId(
            $saleOrder->getIdentifiers()->storeId() ?? '',
            $userId
        );

        if (!$marketplace) {
            return 0.0;
        }

        $items = collect($saleOrder->getItems());

        return $items->sum(function(Item $item) use ($userId, $marketplace) {
            if (!$product = $this->productRepository->get($item->getSku(), $userId)) {
                return 0.0;
            }

            $value = $this->getValue($item);

            $freight = $this->freightRepository->get(
                $marketplace,
                $product->getCubicWeight(),
                $value
            );
            $price = CalculatedPrice::fromProduct(
                $product,
                MoneyTransformer::toMoney(
                    $this->commissionRepository->get($marketplace, $product, $value),
                ),
                new CalculatorForm(
                    desiredPrice: $value,
                    freight: $freight
                )
            );
            $itemProfit = $price->getProfit()->multiply(
                $item->getQuantity()
            );

            return MoneyTransformer::toFloat($itemProfit);
        });
    }

    private function getValue(Item $item): float
    {
        $unitValue = MoneyTransformer::toMoney($item->getUnitValue());
        $discount = MoneyTransformer::toMoney($item->getDiscount());
        $value = $unitValue->subtract($discount);

        return MoneyTransformer::toFloat($value);
    }
}
