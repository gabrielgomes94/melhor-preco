<?php

namespace Src\Calculator\Application\Services;

use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Users\Domain\Entities\User;

class CalculateProfit
{
    private CalculatePrice $calculatePrice;
    private MarketplaceRepository $marketplaceRepository;
    private ProductRepository $productRepository;

    public function __construct(
        CalculatePrice $calculatePrice,
        MarketplaceRepository $marketplaceRepository,
        ProductRepository $productRepository
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->marketplaceRepository = $marketplaceRepository;
        $this->productRepository = $productRepository;
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

        $price = $this->calculatePrice->calculate(
            ProductData::fromModel($product),
            $marketplace,
            $price->value,
            Percentage::fromPercentage($price->commission ?? 0.0),
        );

        return MoneyTransformer::toFloat($price->getProfit());
    }
}
