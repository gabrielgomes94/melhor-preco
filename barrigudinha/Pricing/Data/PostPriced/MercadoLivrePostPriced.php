<?php

namespace Barrigudinha\Pricing\Data\PostPriced;

use Barrigudinha\Pricing\Data\PostPriced\Contracts\HasSecondaryPrice;
use Barrigudinha\Pricing\Price\Price;
use Barrigudinha\Product\Entities\Post;
use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Store\Store;
use Barrigudinha\Utils\Helpers;

class MercadoLivrePostPriced extends PostPriced implements HasSecondaryPrice
{
    private Price $priceWithoutFreight;

    public function __construct(Post $post, Price $price, Product $product, array $options = [])
    {
        parent::__construct($post, $price, $product);

        $commission = Helpers::percentage($options['commission'] ?? $post->store()->commission());

        $this->priceWithoutFreight = new Price(
            product: $product,
            value: $price->get(),
            store: Store::MERCADO_LIVRE,
            commission: $commission,
            options: [
                'ignoreFreight' => true,
            ]
        );
    }

    public function secondaryPrice(): Price
    {
        return $this->priceWithoutFreight;
    }
}
