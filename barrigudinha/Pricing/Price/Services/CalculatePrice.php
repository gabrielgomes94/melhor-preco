<?php

namespace Barrigudinha\Pricing\Price\Services;

use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Pricing\Price\Services\Contracts\CalculatePrice as CalculatePriceInterface;
use Barrigudinha\Product\Product;
use Barrigudinha\Product\Store;
use Barrigudinha\Utils\Helpers;
use Money\Money;

class CalculatePrice implements CalculatePriceInterface
{
    public function calculate(
        Product $product,
        Store $store,
        Money $desiredPrice,
        float $commission = 0.0,
        float $discount = 0.0
    ): Price {
        $commission = Helpers::percentage($commission);
        $discount = Helpers::percentage($discount);

        $price = new Price(
            product: $product,
            value: $desiredPrice,
            store: $store->slug(),
            commission: $commission,
            discountRate:  $discount
        );

        return $price;
    }

    public function recalculate(
        Product $product,
        Store $store,
    ): Price {
        $post = $product->getPost($store->slug());

        return $this->calculate($product, $store, $post->price());
    }
}
