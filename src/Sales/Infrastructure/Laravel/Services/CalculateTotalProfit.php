<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Services\CalculatePrice;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\Models\Contracts\SaleOrder;
use Src\Sales\Domain\Services\CalculateTotalProfit as CalculateTotalProfitInterface;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class CalculateTotalProfit implements CalculateTotalProfitInterface
{
    public function __construct(
        private readonly CalculatePrice $calculatePrice,
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly ProductRepository $productRepository
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

            $price = $this->calculatePrice->calculate(
                $product,
                $marketplace,
                new CalculatorForm($this->getValue($item))
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
