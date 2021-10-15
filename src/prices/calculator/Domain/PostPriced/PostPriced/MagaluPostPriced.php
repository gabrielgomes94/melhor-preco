<?php

namespace Src\Prices\Calculator\Domain\PostPriced;

use Src\Prices\Calculator\Domain\PostPriced\PostPriced;
use Src\Products\Domain\Entities\Post;
use Src\Products\Domain\Entities\Product;
use Barrigudinha\Utils\Helpers;
use Src\Prices\Calculator\Domain\PostPriced\Contracts\HasSecondaryPrice;
use Src\Prices\Calculator\Domain\Price\Price;

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
