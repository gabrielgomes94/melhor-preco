<?php

namespace Src\Prices\Domain\PostPriced;

use Src\Products\Domain\Entities\Post;
use Src\Products\Domain\Entities\Product;
use Barrigudinha\Store\Store;
use Barrigudinha\Utils\Helpers;
use Src\Prices\Domain\PostPriced\Contracts\HasSecondaryPrice;
use Src\Prices\Domain\Price\Price;

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
