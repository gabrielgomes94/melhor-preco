<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Users\Domain\Entities\User;

class CalculateProfit
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private ProductRepository $productRepository,
        private CommissionRepository $commissionRepository
    ) {
    }

    /**
     * @throws ProductNotFoundException
     */
    public function fromModel(Price $price, User $user): float
    {
        $sku = $price->product_sku;
        $marketplace = $this->marketplaceRepository->getByErpId(
            $price->getMarketplaceErpId(),
            $user->getId()
        );

        if (!$product = $this->productRepository->get($sku, $user->getId())) {
            throw new ProductNotFoundException($sku);
        }

        $price = CalculatedPrice::fromProduct(
            $product,
            $this->commissionRepository->get(
                $marketplace,
                $product,
                MoneyTransformer::toMoney($price->value)
            ),
            new CalculatorForm(desiredPrice: $price->value)
        );

        return MoneyTransformer::toFloat($price->getProfit());
    }
}
