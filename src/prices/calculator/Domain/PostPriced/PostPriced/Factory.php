<?php

namespace Src\Prices\Calculator\Domain\PostPriced;

use Src\Prices\Calculator\Domain\PostPriced\MagaluPostPriced;
use Src\Prices\Calculator\Domain\PostPriced\MercadoLivrePostPriced;
use Src\Prices\Calculator\Domain\PostPriced\PostPriced;
use Src\Products\Domain\Entities\Post;
use Src\Products\Domain\Entities\Product;
use Src\Prices\Calculator\Domain\Price\Price;

class Factory
{
    public static function make(Post $post, Price $price, Product $product, array $options = []): PostPriced
    {
        $store = $post->store()->slug();

        if ($store === 'magalu') {
            return new MagaluPostPriced($post, $price, $product, $options);
        }

        if ($store === 'mercado_livre') {
            return new MercadoLivrePostPriced($post, $price, $product, $options);
        }

        return new PostPriced($post, $price, $product, $options);
    }
}
