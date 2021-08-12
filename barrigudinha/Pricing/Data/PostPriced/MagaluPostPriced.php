<?php

namespace Barrigudinha\Pricing\Data\PostPriced;

use Barrigudinha\Pricing\Data\PostPriced\Contracts\HasSecondaryPrice;
use Barrigudinha\Pricing\Price\Price;
use Barrigudinha\Product\Entities\Post;
use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Utils\Helpers;

class MagaluPostPriced extends PostPriced implements HasSecondaryPrice
{
    private const IN_CASH_DISCOUNT = 5.0;
    private Price $discountedPrice;

    public function __construct(Post $post, Price $price, Product $product, array $options = [])
    {
        parent::__construct($post, $price, $product);

        $commission = Helpers::percentage($options['commission'] ?? $post->store()->commission());

        $this->discountedPrice = new Price(
            product: $product,
            value: $price->get(),
            store: $post->store()->slug(),
            commission: $commission,
            discountRate: Helpers::percentage(self::IN_CASH_DISCOUNT)
        );
    }

    public function secondaryPrice(): Price
    {
        return $this->discountedPrice;
    }
}
