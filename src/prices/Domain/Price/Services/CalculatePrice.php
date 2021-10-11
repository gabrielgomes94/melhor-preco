<?php

namespace Src\Prices\Domain\Price\Services;

use Src\Prices\Domain\Contracts\Services\Calculator\CalculatePrice as CalculatePriceInterface;
use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Store;
use Barrigudinha\Utils\Helpers;
use Money\Money;
use Src\Prices\Domain\Price\Price;

class CalculatePrice implements CalculatePriceInterface
{
    public function calculate(
        Product $product,
        Store $store,
        Money $desiredPrice,
        array $options = []
    ): Price {
        $commission = Helpers::percentage($options['commission'] ?? $store->commission());
        $discount = Helpers::percentage($options['discount'] ?? 0.0);

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
