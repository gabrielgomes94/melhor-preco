<?php

namespace Src\Calculator\Application\Services;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Price;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

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
     * @param Price $price
     * @return float
     * @throws ProductNotFoundException
     */
    public function fromModel(Price $price): float
    {
        $sku = $price->product_sku;
        $marketplace = $this->marketplaceRepository->getByErpId(
            $price->getMarketplaceErpId()
        );

        if (!$product = $this->productRepository->get($sku)) {
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
