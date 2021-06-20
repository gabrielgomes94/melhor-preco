<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\PostPriced\Factory as PostPricedFactory;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Product\Product;
use Barrigudinha\Utils\Helpers;
use Money\Money;

class Calculate
{
    public function calculate(
        Product $product,
        string $store,
        $desiredPrice,
        float $commission = 0.0,
        float $additionalCosts = 0.0,
        float $discount = 0.0
    ): PostPriced {
        $commission = Helpers::percentage($commission);
        $discount = Helpers::percentage($discount);
        $additionalCosts = Helpers::floatToMoney($additionalCosts ?? 0.0);

        if (!$desiredPrice instanceof Money) {
            $desiredPrice = Helpers::floatToMoney((float) $desiredPrice);
        }

        $price = new Price($product, $desiredPrice, $store, $additionalCosts, $commission, $discount);
        $post = $product->post($store);

        return PostPricedFactory::make($post, $price, $product);
    }
}
