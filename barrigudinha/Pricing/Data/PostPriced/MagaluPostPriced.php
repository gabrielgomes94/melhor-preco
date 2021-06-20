<?php

namespace Barrigudinha\Pricing\Data\PostPriced;

use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Product\Post;
use Barrigudinha\Product\Product;
use Barrigudinha\Utils\Helpers;

class MagaluPostPriced extends PostPriced
{
    private const IN_CASH_DISCOUNT = 5.0;

    private Price $discountedPrice;

    public function __construct(Post $post, Price $price, Product $product)
    {
        parent::__construct($post, $price, $product);

        $this->discountedPrice = new Price(
            product: $product,
            value: $price->get(),
            store: $post->store()->slug(),
            commission: Helpers::percentage($post->store()->commission()),
            discountRate: Helpers::percentage(self::IN_CASH_DISCOUNT)
        );
    }

    public function discountedPrice(): Price
    {
        return $this->discountedPrice;
    }
}
