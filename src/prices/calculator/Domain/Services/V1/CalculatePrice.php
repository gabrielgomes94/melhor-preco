<?php

namespace Src\Prices\Calculator\Domain\Services\V1;

use Src\Prices\Calculator\Domain\Contracts\Services\V1\CalculatePrice as CalculatePriceInterface;
use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Store;
use Barrigudinha\Utils\Helpers;
use Money\Money;
use Src\Prices\Calculator\Domain\Price\V1\Price;

class CalculatePrice implements \Src\Prices\Calculator\Domain\Contracts\Services\V1\CalculatePrice
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
