<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Post\Post;

trait WithSecondaryPriceFactory
{
    private function getCommission(Post $post): Percentage
    {
        $price = $post->getCalculatedPrice();
        $commissionRate = $price->getCommission()->getCommissionRate();

        return Percentage::fromFraction($commissionRate);
    }

    private function getProductData(Post $post): ProductData
    {
        $product = $post->getProduct();

        return ProductData::fromModel($product);
    }

    private function getSecondaryPriceCalculated(Post $post, array $options = []): Price
    {
        return $this->calculatePriceService->calculate(
            productData: $this->getProductData($post),
            marketplace: $post->getMarketplace(),
            value: $this->getValue($post),
            commission: $this->getCommission($post),
            options: $options
        );
    }

    private function getValue(Post $post): float
    {
        $price = $post->getCalculatedPrice();

        return MoneyTransformer::toFloat($price->get());
    }
}
